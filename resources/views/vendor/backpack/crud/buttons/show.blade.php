@if ($crud->hasAccess('show'))
	@if (!$crud->model->translationEnabled())

	<!-- Single edit button -->
	<a href="{{ url($crud->route.'/'.$entry->getKey().'/show') }}" class="btn btn-sm btn-outline-primary" tooltip><i class="la la-eye" data-toggle="tooltip" title="Show"></i></a>

	@else

	<!-- Edit button group -->
	<div class="btn-group">
	  <a href="{{ url($crud->route.'/'.$entry->getKey().'/show') }}" class="btn btn-sm btn-outline-primary pr-0" tooltip><i class="la la-eye" data-toggle="tooltip" title="Show"></i></a>
	  <a class="btn btn-sm btn-link dropdown-toggle text-primary pl-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    <span class="caret"></span>
	  </a>
	  <ul class="dropdown-menu dropdown-menu-right">
  	    <li class="dropdown-header">{{ trans('backpack::crud.preview') }}:</li>
	  	@foreach ($crud->model->getAvailableLocales() as $key => $locale)
		  	<a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/show') }}?_locale={{ $key }}">{{ $locale }}</a>
	  	@endforeach
	  </ul>
	</div>

	@endif
@endif