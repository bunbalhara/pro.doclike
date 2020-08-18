@foreach ($subcategoryData as $sub)
<div class="subcategory-row my-3 row" style="cursor: pointer">
    <div class="col-10 subcategory-name">
        {{$sub->name}}
    </div>
    <div class="col-2 my-auto">
        <input type="radio" name="subcategory" value="{{$sub->id}}">
    </div>
</div>
@endforeach