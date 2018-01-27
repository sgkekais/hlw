@extends(Config::get('chatter.master_file_extend'))

@section(Config::get('chatter.yields.head'))
    <link href="/vendor/devdojo/chatter/assets/vendor/spectrum/spectrum.css" rel="stylesheet">
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

<div id="chatter" class="chatter_home h-100 bg-light">
{{-- TODO: fix layout (edit & delete buttons, mobile editor), let admins delete any post or discussion, pinning, closing, view count --}}
	<div id="chatter_hero" style="box-shadow: inset 0px 5px 5px 0px rgba(100,100,100,0.5);">
		<div id="chatter_hero_dimmer"></div>
		<?php $headline_logo = Config::get('chatter.headline_logo'); ?>
		@if( isset( $headline_logo ) && !empty( $headline_logo ) )
			<img src="{{ Config::get('chatter.headline_logo') }}">
		@else
			<h1 class=""><span class="p-2">{{ Config::get('chatter.headline') }}</span> </h1>
			<p><span class="px-2 text-white">{{ Config::get('chatter.description') }}</span></p>
		@endif
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

	<div class="container chatter_container">

	    <div class="row mt-4">

	    	<div class="col-md-3 left-column">
	    		<!-- SIDEBAR -->
	    		<div class="chatter_sidebar">
					@auth
						<button class="btn btn-primary" id="new_discussion_btn">
                            <i class="fa fa-fw fa-plus-circle"></i> Neue {{ Config::get('chatter.titles.discussion') }}
                        </button>
					@endauth
                    <h2 class="font-weight-bold font-italic mt-2">Filtern</h2>
					<ul class="list-group">
                        <li class="list-group-item">
                            <a href="/{{ Config::get('chatter.routes.home') }}"><span class="fa fa-fw fa-comment-o"></span> Alle {{ Config::get('chatter.titles.discussions') }}</a>
                        </li>
						@foreach($categories->sortBy('name') as $category)
							<li class="list-group-item">
								<span class="fa fa-fw fa-square" style="color:{{ $category->color }}"></span>
								<a href="/{{ Config::get('chatter.routes.home') }}/{{ Config::get('chatter.routes.category') }}/{{ $category->slug }}">
                                    {{ $category->name }}
                                </a>
                            </li>
						@endforeach
					</ul>
				</div>
				<!-- END SIDEBAR -->
	    	</div>
	        <div class="col-md-9 right-column">
	        	<div class="panel">
		        	<ul class="discussions" style="border: 1px solid rgba(0, 0, 0, 0.125)">
		        		@foreach ($discussions->groupBy('sticky') as $sticky)
							@foreach ($sticky as $discussion)
								<li class="border border-top-0 border-right-0 border-left-0 {{ $loop->last && $discussion->sticky ? "border-dark" : null }}">
									<a class="discussion_list d-flex p-3" href="/{{ Config::get('chatter.routes.home') }}/{{ Config::get('chatter.routes.discussion') }}/{{ $discussion->category->slug }}/{{ $discussion->slug }}">
										<div class="chatter_avatar pr-3">
										@if(Config::get('chatter.user.avatar_image_database_field'))

                                            <?php $db_field = Config::get('chatter.user.avatar_image_database_field'); ?>

											<!-- If the user db field contains http:// or https:// we don't need to use the relative path to the image assets -->
												@if( (substr($discussion->user->{$db_field}, 0, 7) == 'http://') || (substr($discussion->user->{$db_field}, 0, 8) == 'https://') )
													<img src="{{ $discussion->user->{$db_field}  }}">
												@else
													<img src="{{ Config::get('chatter.user.relative_url_to_image_assets') . $discussion->user->{$db_field}  }}">
												@endif

											@else

												<span class="chatter_avatar_circle" style="background-color:#<?= \DevDojo\Chatter\Helpers\ChatterHelper::stringToColorCode($discussion->user->name) ?>">
													{{ strtoupper(substr($discussion->user->name, 0, 1)) }}
												</span>

											@endif
										</div>

										<div class="chatter_middle pull-left">
											<h4 class="chatter_middle_title m-0 p-0 text-dark">
												@if ($discussion->sticky)
													<span class="fa fa-thumb-tack text-secondary"></span>
												@endif
												{{ $discussion->title }}
											</h4>
											@if($discussion->post[0]->markdown)
                                                <?php $discussion_body = GrahamCampbell\Markdown\Facades\Markdown::convertToHtml( $discussion->post[0]->body ); ?>
											@else
                                                <?php $discussion_body = $discussion->post[0]->body; ?>
											@endif
											<p>{{ substr(strip_tags($discussion_body), 0, 80) }}@if(strlen(strip_tags($discussion_body)) > 80){{ '...' }}@endif</p>
											<span class="chatter_middle_details">
												Von: <span data-href="/user">{{ ucfirst($discussion->user->{Config::get('chatter.user.database_field_with_user_name')}) }}</span>
												{{ \Carbon\Carbon::createFromTimeStamp(strtotime($discussion->created_at))->diffForHumans() }}, in
												<span class="badge badge-pill text-white font-weight-normal" style="background-color:{{ $discussion->category->color }}">{{ $discussion->category->name }}</span>
											</span>
										</div>

										<div class="ml-auto d-inline d-md-block text-secondary">
											@if ($discussion->postsCount[0]->total > 0)
												<span class="fa fa-fw fa-comment" title="Antworten"></span>
											@else
												<span class="fa fa-fw fa-comment-o" title="Antworten"></span>
											@endif
											{{ $discussion->postsCount[0]->total }}

											@if ($discussion->views > 1)
												<span class="fa fa-fw fa-eye" title="Aufrufe"></span>
												{{ $discussion->views }}
											@else
												<span class="fa fa-fw fa-eye-slash" title="Aufrufe"></span>
												0
											@endif
										</div>

										<div class="chatter_clear"></div>
									</a>
								</li>
							@endforeach
			        	@endforeach
		        	</ul>
	        	</div>

	        	<div id="pagination">
                    <div class="clearfix mt-3">
                        {{ $discussions->links('vendor.pagination.bootstrap-4') }}
                        <span class="pull-right">
                            <a href="#top"><i class="fa fa-fw fa-arrow-up"></i> nach oben</a>
                        </span>
                    </div>
	        	</div>


	        </div>
	    </div>
	</div>

	<div id="new_discussion" class="border border-right-0 border-bottom-0 border-left-0 border-secondary">

    	<div class="chatter_loader dark" id="new_discussion_loader">
		    <div></div>
		</div>

    	<form id="chatter_form_editor" action="/{{ Config::get('chatter.routes.home') }}/{{ Config::get('chatter.routes.discussion') }}" method="POST">
        	<div class="row">
	        	<div class="col-10 pr-0 d-flex flex-column flex-md-row">
		        	<!-- TITLE -->
	                <input type="text" class="form-control" id="title" name="title" placeholder="Titel der {{ Config::get('chatter.titles.discussion') }}" v-model="title" value="{{ old('title') }}" >
		            <!-- CATEGORY -->
					<select id="chatter_category_id" class="form-control" name="chatter_category_id" title="Kategorie auswählen">
						<option value="">Kategorie auswählen</option>
						@foreach($categories as $category)
							@if(old('chatter_category_id') == $category->id)
								<option value="{{ $category->id }}" selected>{{ $category->name }}</option>
							@else
								<option value="{{ $category->id }}">{{ $category->name }}</option>
							@endif
						@endforeach
					</select>
		        </div>

		        <div class="col-2 pl-0 text-right">
		        	<i class="chatter-close"></i>
		        </div>
	        </div><!-- .row -->

            <!-- BODY -->
        	<div id="editor">
        		@if( $chatter_editor == 'tinymce' || empty($chatter_editor) )
					<label id="tinymce_placeholder"></label>
    				<textarea id="body" class="richText" name="body" placeholder="">{{ old('body') }}</textarea>
				@endif
    		</div>

            <input type="hidden" name="_token" id="csrf_token_field" value="{{ csrf_token() }}">

            <div id="new_discussion_footer">
            	{{--<input type='text' id="color" name="color" /><span class="select_color_text">Select a Color for this Discussion (optional)</span>--}}
            	<button id="submit_discussion" class="btn btn-success pull-right"><i class="fa fa-fw fa-plus-circle"></i>{{ Config::get('chatter.titles.discussion') }} anlegen</button>
            	<a href="/{{ Config::get('chatter.routes.home') }}" class="btn btn-default pull-right" id="cancel_discussion">Abbrechen</a>
            	<div class="clearfix"></div>
            </div>
        </form>

    </div><!-- #new_discussion -->

</div>

@if( $chatter_editor == 'tinymce' || empty($chatter_editor) )
	<input type="hidden" id="chatter_tinymce_toolbar" value="{{ Config::get('chatter.tinymce.toolbar') }}">
	<input type="hidden" id="chatter_tinymce_plugins" value="{{ Config::get('chatter.tinymce.plugins') }}">
@endif
<input type="hidden" id="current_path" value="{{ Request::path() }}">

@endsection

@section(Config::get('chatter.yields.footer'))

	@if( $chatter_editor == 'tinymce' || empty($chatter_editor) )
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

	<script src="/vendor/devdojo/chatter/assets/js/chatter.js"></script>
	<script>
		$('document').ready(function(){

			$('.chatter-close').click(function(){
				$('#new_discussion').slideUp();
			});
			$('#new_discussion_btn, #cancel_discussion').click(function(){
				@if(Auth::guest())
					window.location.href = "/{{ Config::get('chatter.routes.home') }}/login";
				@else
					$('#new_discussion').slideDown();
					$('#title').focus();
				@endif
			});

			@if (count($errors) > 0)
				$('#new_discussion').slideDown();
				$('#title').focus();
			@endif

		});
	</script>
@stop
