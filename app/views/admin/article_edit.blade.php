<div class="row">
    <form action="/admin/article/{{ $article->id }}" method="post">
        <ul>
            <li class="field"><input class="text input" type="text" name="title" placeholder="Title" value="{{ $article->title }}"></li>
            <li class="field"><input class="text input" type="text" name="tags" placeholder="Tags" value="{{ $tags }}"></li>
            <li class="field">
                <select name="status_id">
                    @foreach($statuses as $status)
                    <option value="{{ $status->id }}" @if($status->slug == $article->status->slug)selected@endif>{{ $status->status }}</option>
                    @endforeach
                </select>
            </li>
            <li class="field"><textarea class="input textarea" placeholder="Excerpt" name="excerpt" rows="3">{{ $article->excerpt }}</textarea></li>
            <li class="field"><textarea class="input textarea" placeholder="Content" name="content" rows="5">{{ $article->content }}</textarea></li>
        </ul>
        <input type="hidden" name="_method" value="PUT" />
    </form>
</div>