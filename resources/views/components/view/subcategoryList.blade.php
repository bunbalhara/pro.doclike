<div class="slick-subcategory-part">
    @foreach ($subcategoryData as $subcategory)
    <button type="button" class="subcat-btn btn btn-primary btn-rounded" data-id="{{$subcategory->id}}" style="border: 1px solid white">
        {{substr($subcategory->name, 0, 10)}}
    </button>                                                
    @endforeach
</div>


<script>
    $('.slick-subcategory-part').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true
    });
</script>