<style>
    .thumb{
        margin-bottom: 10px;
        padding: 4px;
    }

    .caption {
        padding-left: 5px;
        padding-right: 5px;
    }
</style>

@foreach($photos as $photo)
    <div class="col-lg-3 col-md-4 col-xs-6 thumb">
        <a class="thumbnail" target="_blank" href="http://500px.com{{ $photo->url }}">
            <img class="img-responsive" src="{{ $photo->image_url }}" alt="{{ $photo->name }}">
        </a>
        <div class="caption">
            <a class="pull-left" href="#">{{ $photo->user->fullname }}</a>
            <p class="pull-right fa fa-heart"> {{ $photo->favorites_count }}</p>
            <p class="pull-right fa fa-thumbs-up"> {{ $photo->votes_count }}</p>
        </div>

    </div>
@endforeach