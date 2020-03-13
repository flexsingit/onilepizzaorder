@if(count($list_filters) > 0)
<div class="col-md-12 col-sm-12 col-xs-12" @if(!$show_filters) style="display:none;" @endif>
    <div class="x_panel">
        <div class="x_title">
            <h4>List Filters</h4>
            <ul class="nav navbar-right panel_toolbox">
                <li style="float:right;"><a class="collapse-link" style="color:#C5C7CB"><i class="fa fa-chevron-down"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content" style="display:none;">
            <div class="row">
                <form id="list_filter_form" method="GET" novalidate="true" onsubmit="return false;">
                    @foreach($list_filters as $filter)
                        @if($filter['type'] == 'hidden')
                            <input id="{{$filter['name']}}" type="hidden" name="{{$filter['name']}}" value="{{$filter['value']}}" />
                        @else
                            <div class="form-group col-xs-12 col-sm-3 @if(isset($filter['group_class'])) {{$filter['group_class']}} @endif">
                                <label class="control-label">{{$filter['label']}}</label>
                                @if ($filter['type'] == 'text')
                                    <input id="{{$filter['name']}}" type="text" name="{{$filter['name']}}" class="form-control @if(isset($filter['class'])) {{$filter['class']}} @endif" value="@if(isset($filter['value'])) {{$filter['value']}} @endif" @if(isset($filter['js'])) {!! $filter['js'] !!} @endif/>
                                @elseif($filter['type'] == 'select')
                                    @if(isset($filter['multiple']) && $filter['multiple'] == true)
                                        <select name="{{$filter['name']}}[]" id="{{$filter['name']}}" class="form-control @if(isset($filter['class'])) {{$filter['class']}} @endif" @if(isset($filter['multiple'])) multiple="multiple" @endif  @if(isset($filter['js'])) {!! $filter['js'] !!} @endif>
                                    @else
                                        <select name="{{$filter['name']}}" id="{{$filter['name']}}" class="form-control @if(isset($filter['class'])) {{$filter['class']}} @endif"  @if(isset($filter['js'])) {!! $filter['js'] !!} @endif>
                                    @endif
                                        <option value="">Select {{$filter['label']}}</option>
                                    @if(isset($filter['options']) && count($filter['options']) > 0)
                                        @foreach($filter['options'] as $o_key => $o_value)
                                            <option value="{{$o_key}}" @if(isset($filter['value']) && $filter['value'] == $o_key) selected="selected" @endif >{{$o_value}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @elseif($filter['type'] == 'date')
                                    <input id="{{$filter['name']}}" type="text" name="{{$filter['name']}}" class="hasdatepicker form-control @if(isset($filter['class'])) {{$filter['class']}} @endif" value="@if(isset($filter['value'])) {{$filter['value']}} @endif"  @if(isset($filter['js'])) {!! $filter['js'] !!} @endif/>
                                @else
                                    <input id="{{$filter['name']}}" type="text" name="{{$filter['name']}}" class="form-control @if(isset($filter['class'])) {{$filter['class']}} @endif" value="@if(isset($filter['value'])) {{$filter['value']}} @endif"  @if(isset($filter['js'])) {!! $filter['js'] !!} @endif/>
                                @endif
                            </div>
                        @endif
                    @endforeach
                    <div class="clearfix"></div>
                    <div class="col-xs-12">
                        <button type="reset" class="btn btn-warning resetbtn" onclick="resetFilters(this)">Reset</button>
                        <button type="button" class="btn btn-info searchbtn" onclick="filterList(this)">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif