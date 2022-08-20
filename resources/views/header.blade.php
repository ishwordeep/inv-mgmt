@section('header')
    <section class="container-fluid">
	  <h2>
	  	<span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
      	<small id="datatable_info_stack">{!! $crud->getSubheading() ?? '' !!}</small>

        @if($crud->hasAccess('create'))
          <small><a href="{{ url($crud->route) }}" class="d-print-none font-sm"><i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
        @endif
	  </h2>
	</section>
@endsection