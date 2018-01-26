@extends(Config::get('chatter.master_file_extend'))

@section(Config::get('chatter.yields.head'))
    @if(Config::get('chatter.sidebar_in_discussion_view'))
        <link href="/vendor/devdojo/chatter/assets/vendor/spectrum/spectrum.css" rel="stylesheet">
    @endif
    <link href="/vendor/devdojo/chatter/assets/css/chatter.css" rel="stylesheet">
    @if($chatter_editor == 'simplemde')
        <link href="/vendor/devdojo/chatter/assets/css/simplemde.min.css" rel="stylesheet">
    @elseif($chatter_editor == 'trumbowyg')
        <link href="/vendor/devdojo/chatter/assets/vendor/trumbowyg/ui/trumbowyg.css" rel="stylesheet">
        <style>
            .trumbowyg-box, .trumbowyg-editor {
                margin: 0px auto;
            }
        </style>
    @endif
@stop


@section('content')

<div id="chatter" class="discussion">

	<div id="chatter_header" style="background-color:{{ $discussion->color }}">
		<div class="container d-flex flex-column flex-sm-row justify-content-between align-items-center">
            <div class="" style="width: 50px">
                <a class="" href="/{{ Config::get('chatter.routes.home') }}">
                    <span class="rounded-circle bg-primary p-2">
                        <i class="fa fa-fw fa-arrow-left"></i>
                    </span>
                </a>
            </div>
            <h1 class="pl-3 m-0 text-center text-sm-left">{{ $discussion->title }}</h1>
			<div class="ml-sm-auto text-white text-center text-sm-right my-2">
                <a class="badge badge-pill font-weight-normal text-white" href="/{{ Config::get('chatter.routes.home') }}/{{ Config::get('chatter.routes.category') }}/{{ $discussion->category->slug }}" style="background-color:{{ $discussion->category->color }}; font-size: .9rem">
                    {{ $discussion->category->name }}
                </a>
            </div>
		</div>
	</div>

	@if(Session::has('chatter_alert'))
		<div class="chatter-alert alert alert-{{ Session::get('chatter_alert_type') }}">
			<div class="container">
	        	<strong><i class="chatter-alert-{{ Session::get('chatter_alert_type') }}"></i> {{ Config::get('chatter.alert_messages.' . Session::get('chatter_alert_type')) }}</strong>
	        	{{ Session::get('chatter_alert') }}
	        	<i class="chatter-close"></i>
	        </div>
	    </div>
	    <div class="chatter-alert-spacer"></div>
	@endif

	@if (count($errors) > 0)
	    <div class="chatter-alert alert alert-danger">
	    	<div class="container">
	    		<p><strong><i class="chatter-alert-danger"></i> {{ Config::get('chatter.alert_messages.danger') }}</strong> Bitte korrigier die folgenden Fehler:</p>
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
	    </div>
	@endif

	<div class="container ">
	    <div class="row mt-4">
            <div class="col-md-12">
				<div class="conversation">
	                <ul class="discussions no-bg" style="display:block;">
	                	@foreach($posts as $post)
	                		<li class="border border-left-0 border-top-0 border-right-0 py-4" data-id="{{ $post->id }}" data-markdown="{{ $post->markdown }}">
		                		<div class="chatter_posts d-flex">
                                    <!-- user info -->
                                    <div class="pr-3 text-center">
                                        <div class="chatter_avatar" style="min-width: 100px">
                                            @if(Config::get('chatter.user.avatar_image_database_field'))

                                                <?php $db_field = Config::get('chatter.user.avatar_image_database_field'); ?>

                                                <!-- If the user db field contains http:// or https:// we don't need to use the relative path to the image assets -->
                                                    @if( (substr($post->user->{$db_field}, 0, 7) == 'http://') || (substr($post->user->{$db_field}, 0, 8) == 'https://') )
                                                        <img src="{{ $post->user->{$db_field}  }}">
                                                    @else
                                                        <img src="{{ Config::get('chatter.user.relative_url_to_image_assets') . $post->user->{$db_field}  }}">
                                                    @endif

                                            @else
                                                <span class="chatter_avatar_circle" style="background-color:#<?= \DevDojo\Chatter\Helpers\ChatterHelper::stringToColorCode($post->user->name) ?>">
                                                    {{ ucfirst(substr($post->user->name, 0, 1)) }}
                                                </span>
                                            @endif
                                        </div>
                                        <ul class="list-unstyled py-1 text-secondary">
                                            @foreach ($post->user->roles as $role)
                                                <li>{{ $role->display_name }}</li>
                                            @endforeach
                                        </ul>
                                        @if (!$post->user->clubs->isEmpty())
                                            <span class="fa fa-fw fa-heart text-danger" title="Favoriten" style="font-size: 12px"></span>
                                            <ul class="list-inline">
                                                @foreach ($post->user->clubs as $club)
                                                    @if ($club->logo_url)
                                                        <li class="list-inline-item {{ !$loop->last ? "mr-1" : null }}"><img src="{{ asset('storage/'.$club->logo_url) }}" title="{{ $club->name_short }}" width="25"></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
					        		</div>
                                    <!-- middle -->
					        		<div class="chatter_middle">
					        			<span class="chatter_middle_details"><a href="{{ \DevDojo\Chatter\Helpers\ChatterHelper::userLink($post->user) }}">{{ ucfirst($post->user->{Config::get('chatter.user.database_field_with_user_name')}) }}</a> <span class="ago chatter_middle_details">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($post->created_at))->diffForHumans() }}</span></span>
					        			<div class="chatter_body">

					        				@if($post->markdown)
					        					<pre class="chatter_body_md">{{ $post->body }}</pre>
					        					<?= \DevDojo\Chatter\Helpers\ChatterHelper::demoteHtmlHeaderTags( GrahamCampbell\Markdown\Facades\Markdown::convertToHtml( $post->body ) ); ?>
					        					<!--?= GrahamCampbell\Markdown\Facades\Markdown::convertToHtml( $post->body ); ?-->
					        				@else
					        					<?= $post->body; ?>
					        				@endif

					        			</div>
					        		</div>
				        		</div>
                                    <!-- control buttons -->
                                    <div class="d-flex flex-column flex-sm-row mt-3 chatter_post_actions">
                                        <small class="mr-auto text-secondary mr-2">
                                            @if ($post->created_at < $post->updated_at)
                                                Zuletzt aktualisiert: {{ $post->updated_at->diffForHumans() }}
                                            @else

                                            @endif
                                        </small>
                                        @if(!Auth::guest() && (Auth::user()->id == $post->user->id))
                                            <button class="btn btn-outline-secondary btn-sm chatter_edit_btn">
                                                <i class="fa fa-fw fa-edit"></i> Bearbeiten
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm chatter_delete_btn mt-1 mt-sm-0 ml-sm-2">
                                                <i class="fa fa-fw fa-trash"></i> Löschen
                                            </button>
                                        @endif
                                    </div>
                                @if(!Auth::guest() && (Auth::user()->id == $post->user->id))
                                    <div id="delete_warning_{{ $post->id }}" class="chatter_warning_delete alert alert-danger text-right mt-2" style="display: none">
                                        <span class="pull-left text-center text-sm-left">
                                            <i class="fa fa-fw fa-warning"></i> Möchtest du deine Antwort wirklich löschen?
                                        </span>
                                        <button class="btn btn-sm btn-default mr-2">Ne, danke.</button>
                                        <button class="btn btn-sm btn-danger delete_response">Ja, lösch sie!</button>
                                    </div>
                                @endif
		                	</li>
	                	@endforeach

	                </ul>
	            </div>

	            <div id="pagination">{{ $posts->links() }}</div>

            <!-- new response -->
            <div class="row">
                <div class="col">
                    @auth
                        <div id="new_response">
                            <h1 class="font-weight-bold font-italic">Antworten</h1>
                            <div id="new_discussion">
                                <div class="chatter_loader dark" id="new_discussion_loader">
                                    <div></div>
                                </div>
                                <form id="chatter_form_editor" action="/{{ Config::get('chatter.routes.home') }}/posts" method="POST">

                                    <!-- BODY -->
                                    <div id="editor">
                                        @if( $chatter_editor == 'tinymce' || empty($chatter_editor) )
                                            <label id="tinymce_placeholder">Beginne hier zu tippen...</label>
                                            <textarea id="body" class="richText" name="body" placeholder="">{{ old('body') }}</textarea>
                                        @elseif($chatter_editor == 'simplemde')
                                            <textarea id="simplemde" name="body" placeholder="">{{ old('body') }}</textarea>
                                        @elseif($chatter_editor == 'trumbowyg')
                                            <textarea class="trumbowyg" name="body" placeholder="Beginne hier zu tippen...">{{ old('body') }}</textarea>
                                        @endif
                                    </div>

                                    <input type="hidden" name="_token" id="csrf_token_field" value="{{ csrf_token() }}">
                                    <input type="hidden" name="chatter_discussion_id" value="{{ $discussion->id }}">
                                </form>
                            </div><!-- #new_discussion -->

                            <div id="discussion_response_email">
                                <button id="submit_response" class="btn btn-success pull-right"><i class="fa fa-fw fa-reply"></i> Antworten</button>
                                @if(Config::get('chatter.email.enabled'))
                                    <div id="notify_email">
                                        <img src="/vendor/devdojo/chatter/assets/images/email.gif" class="chatter_email_loader">
                                        <!-- Rounded toggle switch -->
                                        <span><i class="fa fa-fw fa-envelope"></i> Benachrichtigen?</span>
                                        <label class="switch">
                                            <input type="checkbox" id="email_notification" name="email_notification" @if(!Auth::guest() && $discussion->users->contains(Auth::user()->id)){{ 'checked' }}@endif>
                                            <span class="on">Ja</span>
                                            <span class="off">Nein</span>
                                            <div class="slider round"></div>
                                        </label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    {{-- login or register --}}
                    @else
                        <div id="login_or_register">
                            <p>Bitte <a href="/{{ Config::get('chatter.routes.home') }}/login">melde dich an</a> oder <a href="/{{ Config::get('chatter.routes.home') }}/register">registriere dich</a>, um antzuworten.</p>
                        </div>
                    @endauth
                </div>
            </div>

	        </div>
	    </div>
	</div>

</div>

@if($chatter_editor == 'tinymce' || empty($chatter_editor))
    <input type="hidden" id="chatter_tinymce_toolbar" value="{{ Config::get('chatter.tinymce.toolbar') }}">
    <input type="hidden" id="chatter_tinymce_plugins" value="{{ Config::get('chatter.tinymce.plugins') }}">
@endif
<input type="hidden" id="current_path" value="{{ Request::path() }}">

@stop

@section(Config::get('chatter.yields.footer'))

@if( $chatter_editor == 'tinymce' || empty($chatter_editor) )
	<script>var chatter_editor = 'tinymce';</script>
    <script src="/vendor/devdojo/chatter/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="/vendor/devdojo/chatter/assets/js/tinymce.js"></script>
    <script>
        var my_tinymce = tinyMCE;
        $('document').ready(function(){

            $('#tinymce_placeholder').click(function(){
                my_tinymce.activeEditor.focus();
            });

        });
    </script>
@endif

<script>
	$('document').ready(function(){

		var simplemdeEditors = [];

		$('.chatter_edit_btn').click(function(){
			parent = $(this).parents('li');
			parent.addClass('editing');
			id = parent.data('id');
			markdown = parent.data('markdown');
			container = parent.find('.chatter_middle');

			if(markdown){
				body = container.find('.chatter_body_md');
			} else {
				body = container.find('.chatter_body');
				markdown = 0;
			}

			details = container.find('.chatter_middle_details');

			// dynamically create a new text area
			container.prepend('<textarea id="post-edit-' + id + '"></textarea>');
            // Client side XSS fix
            $("#post-edit-"+id).text(body.html());
			container.append('<div class="chatter_update_actions"><button class="btn btn-success pull-right update_chatter_edit"  data-id="' + id + '" data-markdown="' + markdown + '"><i class="chatter-check"></i> Antwort aktualisieren</button><button href="/" class="btn btn-default pull-right cancel_chatter_edit" data-id="' + id + '"  data-markdown="' + markdown + '">Abbrechen</button></div>');

			// create new editor from text area
			if(markdown){
				simplemdeEditors['post-edit-' + id] = newSimpleMde(document.getElementById('post-edit-' + id));
			} else {
                @if($chatter_editor == 'tinymce' || empty($chatter_editor))
                    initializeNewTinyMCE('post-edit-' + id);
                @endif
			}

		});

		$('.discussions li').on('click', '.cancel_chatter_edit', function(e){
			post_id = $(e.target).data('id');
			markdown = $(e.target).data('markdown');
			parent_li = $(e.target).parents('li');
			parent_actions = $(e.target).parent('.chatter_update_actions');
			if(!markdown){
                @if($chatter_editor == 'tinymce' || empty($chatter_editor))
                    tinymce.remove('#post-edit-' + post_id);
                @endif
			} else {
				$(e.target).parents('li').find('.editor-toolbar').remove();
				$(e.target).parents('li').find('.editor-preview-side').remove();
				$(e.target).parents('li').find('.CodeMirror').remove();
			}

			$('#post-edit-' + post_id).remove();
			parent_actions.remove();

			parent_li.removeClass('editing');
		});

		$('.discussions li').on('click', '.update_chatter_edit', function(e){
			post_id = $(e.target).data('id');
			markdown = $(e.target).data('markdown');

			if(markdown){
				update_body = simplemdeEditors['post-edit-' + post_id].value();
			} else {
                @if($chatter_editor == 'tinymce' || empty($chatter_editor))
                    update_body = tinyMCE.get('post-edit-' + post_id).getContent();
                @endif
			}

			$.form('/{{ Config::get('chatter.routes.home') }}/posts/' + post_id, { _token: '{{ csrf_token() }}', _method: 'PATCH', 'body' : update_body }, 'POST').submit();
		});

		$('#submit_response').click(function(){
			$('#chatter_form_editor').submit();
		});

		// ******************************
		// DELETE FUNCTIONALITY
		// ******************************

		$('.chatter_delete_btn').click(function(){
			parent = $(this).parents('li');
			parent.addClass('delete_warning');
			id = parent.data('id');
			$('#delete_warning_' + id).show();
		});

		$('.chatter_warning_delete .btn-default').click(function(){
			$(this).parent('.chatter_warning_delete').hide();
			$(this).parents('li').removeClass('delete_warning');
		});

		$('.delete_response').click(function(){
			post_id = $(this).parents('li').data('id');
			$.form('/{{ Config::get('chatter.routes.home') }}/posts/' + post_id, { _token: '{{ csrf_token() }}', _method: 'DELETE'}, 'POST').submit();
		});

	});
</script>

<script src="/vendor/devdojo/chatter/assets/js/chatter.js"></script>

@stop
