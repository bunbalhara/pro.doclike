@if (appMessages()->where('type', 'chat')->count())
<span class="badge badge-success">
    {{appMessages()->where('type', 'chat')->count()}}
</span>
@endif