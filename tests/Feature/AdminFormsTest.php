<?php

namespace Tests\Feature;

use DOMDocument;
use DOMXPath;
use HLW\Stadium;
use HLW\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Models\Activity;
use Tests\Concerns\UsesRealRecords;
use Tests\TestCase;

/**
 * Saves every edit form of the admin area unchanged, against the local copy
 * of the production database. The transaction is rolled back afterwards.
 */
class AdminFormsTest extends TestCase
{
    use DatabaseTransactions, UsesRealRecords;

    /**
     * Edit pages that already fail in production, see SmokeTest::KNOWN_BROKEN.
     */
    const KNOWN_BROKEN = [
        '#^admin/divisions-official/\{divisions_official\}/edit$#',
    ];

    public function test_edit_forms_save_unchanged()
    {
        $this->actingAs(User::role('super_admin')->firstOrFail());

        $failures = [];
        $saved = 0;

        foreach (Route::getRoutes() as $route) {
            $uri = $route->uri();
            if (!in_array('GET', $route->methods()) || !preg_match('#^admin/.*/edit$#', $uri)) {
                continue;
            }
            foreach (self::KNOWN_BROKEN as $pattern) {
                if (preg_match($pattern, $uri)) {
                    continue 2;
                }
            }

            $url = $this->fillParameters($uri);
            if ($url === null) {
                continue;
            }

            $page = $this->get($url);
            if ($page->getStatusCode() !== 200) {
                $failures[] = $page->getStatusCode() . "  GET $url";
                continue;
            }

            foreach ($this->updateForms($page->getContent()) as [$action, $data]) {
                $response = $this->from($url)->post($action, $data);
                $saved++;

                if (!$response->isRedirect()) {
                    $failures[] = $response->getStatusCode() . "  {$data['_method']} $action (from $url)";
                } elseif (session('errors') && session('errors')->any()) {
                    $failures[] = "invalid  {$data['_method']} $action (from $url): " . implode(' ', session('errors')->all());
                }
            }
        }

        $this->assertGreaterThan(0, $saved, 'No forms were submitted.');
        fwrite(STDERR, sprintf("\n  %d edit forms saved, %d failing\n", $saved, count($failures)));

        $this->assertSame([], $failures, "Edit forms failing:\n" . implode("\n", $failures));
    }

    public function test_changes_are_written_to_the_activity_log()
    {
        $admin = User::role('super_admin')->firstOrFail();
        $this->actingAs($admin);

        $stadium = Stadium::firstOrFail();
        $stadium->update(['note' => 'activity log test']);

        $entry = Activity::latest('id')->firstOrFail();
        $this->assertSame('updated', $entry->description);
        $this->assertTrue($entry->subject->is($stadium));
        $this->assertTrue($entry->causer->is($admin));
        $this->assertSame('activity log test', $entry->changes()->get('attributes')['note']);

        $this->get('/admin/log')->assertStatus(200)->assertSee('activity log test');
    }

    /**
     * Forms that update a record (PUT/PATCH), with their current values.
     */
    private function updateForms($html)
    {
        $dom = new DOMDocument();
        @$dom->loadHTML('<?xml encoding="utf-8"?>' . $html);
        $xpath = new DOMXPath($dom);
        $forms = [];

        foreach ($xpath->query('//form[@method="POST" or @method="post"]') as $form) {
            $method = $xpath->query('.//input[@name="_method"]', $form)->item(0);
            if (!$method || !in_array(strtoupper($method->getAttribute('value')), ['PUT', 'PATCH'])) {
                continue;
            }

            $pairs = [];
            foreach ($xpath->query('.//input[@name] | .//select[@name] | .//textarea[@name]', $form) as $field) {
                $name = $field->getAttribute('name');
                $type = strtolower($field->getAttribute('type'));

                // browsers do not submit disabled fields
                if ($field->hasAttribute('disabled')) {
                    continue;
                }

                if ($field->nodeName === 'select') {
                    $options = $xpath->query('.//option[@selected]', $field);
                    // like a browser, a single select without a selected option submits its first option
                    if ($options->length === 0 && !$field->hasAttribute('multiple')) {
                        $options = $xpath->query('.//option', $field);
                        $options = $options->length ? [$options->item(0)] : [];
                    }
                    foreach ($options as $option) {
                        $pairs[] = [$name, $option->getAttribute('value')];
                    }
                } elseif ($field->nodeName === 'textarea') {
                    $pairs[] = [$name, $field->textContent];
                } elseif (in_array($type, ['checkbox', 'radio'])) {
                    if ($field->hasAttribute('checked')) {
                        $pairs[] = [$name, $field->getAttribute('value') ?: 'on'];
                    }
                } elseif (!in_array($type, ['file', 'submit', 'button', 'password'])) {
                    $pairs[] = [$name, $field->getAttribute('value')];
                }
            }

            // build nested arrays like name[] the way PHP parses a request
            $query = implode('&', array_map(function ($pair) {
                return urlencode($pair[0]) . '=' . urlencode($pair[1]);
            }, $pairs));
            parse_str($query, $data);

            $action = parse_url($form->getAttribute('action'), PHP_URL_PATH);
            $forms[] = [$action, $data];
        }

        return $forms;
    }
}
