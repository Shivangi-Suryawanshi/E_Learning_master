<?php

function generateBreadcrumb($category){
    $homeUrl = "<li class='breadcrumb-item'><a href='".route('home')."'><i class='la la-home'></i>  ".__t('home')."</a></li><li class='breadcrumb-item'><a href='".route('categories')."'>".__t('topics')."</a></li>";

    $breadCumb = "<ol class='breadcrumb mb-0'>".$homeUrl;

    $html = "<li class='breadcrumb-item active'>{$category->category_name}</li>";

    while ($category->parent_category){
        $category = $category->parent_category;
        $currentName = "<li class='breadcrumb-item'><a href='".route('category_view', $category->slug)."'>{$category->category_name}</a></li>";

        $html = $currentName.' '.$html;
    }
    $breadCumb .= $html.'</ol>';

    return $breadCumb;
}


if ( ! function_exists('form_error')){
    function form_error($errors = null, $error_key = ''){

        $response = [
            'class' => '',
            'message' => '',
        ];

        if ($errors && $errors->has($error_key)){
            $response = [
                'class' => ' has-error ',
                'message' => "<span class='invalid-feedback'><strong>{$errors->first($error_key)}</strong></span>",
            ];
        }

        return (object) $response;
    }
}
if (!function_exists('company_positions')) {
    function company_positions() {
        $company_id = Session::get('company_id');
        $optnList   = '';
        $optionArr = \App\CompanyPosition::select('id','position_en','position_ar')
            ->where('company_id',$company_id)->get();
        foreach($optionArr as $option){
            $optnList .= "<option value=".$option->id.">".$option->position_en."</option>";
        }
        return $optionArr;
    }
}

/* Used in : training matrix structure*/
if (!function_exists('company_departments')) {
    function company_departments() {
        $company_id = Session::get('company_id');
        $optnList   = '';
        $optionArr = \App\CompanyDepartment::where('company_id',$company_id)
            ->select('id','en_department','ar_department')->get();
        foreach($optionArr as $option){
            $optnList .= "<option value=".$option->id.">".$option->en_department."</option>";
        }
        return $optnList;
    }
}
/* Used in : training matrix structure*/
if (!function_exists('company_projects')) {
    function company_projects() {
        $company_id = Session::get('company_id');
        $optnList   = '';
        $optionArr = \App\CompanyProject::where('company_id',$company_id)
            ->select('id','en_project','ar_project')->get();
        foreach($optionArr as $option){
            $optnList .= "<option value=".$option->id.">".$option->en_project."</option>";
        }
        return $optnList;
    }
}
