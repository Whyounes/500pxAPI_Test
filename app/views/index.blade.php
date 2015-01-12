@extends('layouts.master')

@section("content")
<div class="row photos">
    <div class="col-lg-12">
        <h1 class="page-header">Thumbnail Gallery</h1>
    </div>
    @include('partials/photos', ['photos' => $photos])

    <button id="load_more" class="btn btn-primary load_more center-block">Load more</button>
</div>

<hr>
@endsection

@section("scripts")
<script>
    $(function(){
        $('#load_more').click(function(e){
            var page = $(this).data('page') || 2;

            $(this).text("Loading...");

            $.ajax({
                url: '/ajax/index_more',
                data: {page: page},
                type: 'get',
                success: function(data){
                    var photos = $('.photos'),
                        more_photos = $(data);

                    more_photos.insertAfter(photos.find('.thumb:last'));

                    //increment page index
                    $('#load_more').data('page', page + 1);
                }//success
            }).done(function(){
                $("#load_more").text("Load more");
            })
        });
    });
</script>
@endsection
