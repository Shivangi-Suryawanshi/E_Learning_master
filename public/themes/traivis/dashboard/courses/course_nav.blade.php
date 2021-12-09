<style>

.list-group-horizontal-md > .list-group-item.active {
    margin-top: 15px !important;
    margin-bottom: 9px;
}

.list-group-horizontal-md > .list-group-item {
    margin-top: 15px !important;
    margin-bottom: 9px;
}

.form-control {display: block;
    width: 100%;
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #e2e5ec !important;
    border-radius: .25rem;
    box-shadow: 0px 0px 3px 0px rgba(0, 0, 0, 0.2) !important;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;}

    .select2-container .select2-selection--single {height:40px !important;
    box-shadow: 0px 0px 3px 0px rgba(0, 0, 0, 0.2) !important;
    border: 1px solid #e2e5ec !important;}


    .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 35px;
}

.img-thumbnail{width:25% !important;}

.input-group-text {background:#000 !important; color:#fff !important;}

label {
   
    font-size: .92rem !important;
    font-weight: 400 !important;
    color: #646c9a !important;
}

.fs16 {font-size: 16px !important;}


    </style>
    
<div class="course-edit-nav list-group list-group-horizontal-md mb-3 text-center  ">
    @php
        $nav_items = course_edit_navs();
    @endphp

    @if(is_array($nav_items) && count($nav_items))
        @foreach($nav_items as $route => $nav_item)
            <a href="{{route($route, $course->id)}}" class="list-group-item list-group-item-action list-group-item-info {{array_get($nav_item, 'is_active') ? 'active' : ''}}">
                <p class="m-0 fs16"> {!! array_get($nav_item, 'icon') !!} {{array_get($nav_item, 'name')}}</p>
            </a>
        @endforeach
    @endif

    <a href="{{route('publish_course', $course->id)}}" class="list-group-item list-group-item-action list-group-item-info {{request()->is('dashboard/courses/*/publish') ? 'active' : ''}}">
        <p class="m-0 fs16" style="padding-bottom:0px;"><i class="la la-arrow-alt-circle-up"></i>  {{__t('publish')}}</p>
    </a>
</div>

<div class="course-edit-header d-flex mb-3">

    <a href="{{route('my_courses')}}" style="color: #000;font-weight: 700;margin-right: 20px;"> <i class="la la-angle-left"></i> Back to courses</a> | &nbsp;<strong class="header-course-title ellipsis">{{$course->title}}</strong>
    &nbsp;| &nbsp; <span style="color: #000;font-weight: 700;margin-right: 20px;">{!! $course->status_html(false) !!}</span>

    @if($course->status == 1)
        <a style="color: #000;font-weight: 700;margin-right: 20px;background: #fff;padding-right: 10px;padding-left: 10px;box-shadow: rgba(0, 0, 0, 0.15) 0px 2px 8px !important;" href="{{route('course', $course->slug)}}" class="btn btn-sm btn-primary ml-auto" target="_blank"><i class="la la-eye"></i>  {{__t('view')}} </a>
    @else
        <a style="color: #000;font-weight: 700;margin-right: 20px;background: #fff;padding-right: 10px;padding-left: 10px;box-shadow: rgba(0, 0, 0, 0.15) 0px 2px 8px !important;" href="{{route('course', $course->slug)}}" class="btn btn-sm btn-purple ml-auto" target="_blank"><i class="la la-eye"></i> {{__t('preview')}} </a>
    @endif

</div>
