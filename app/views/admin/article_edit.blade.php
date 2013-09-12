<div class="row">
    @if( count($errors->all()) )
    <ul>
        @foreach ($errors->all() as $error)
        <li class="danger alert">{{ $error }}</li>
        @endforeach
    </ul>
    @endif
    <form action="/admin/article/{{ $article->id }}" method="post">
        <ul>
            <li class="field">
                <label for="title" class="inline">Title</label>
                <input class="text input" type="text" name="title" id="title" placeholder="Title" value="{{ $article->title }}">
            </li>
            <li class="field">
                <label for="tags" class="inline">Tags</label>
                <input class="text input" type="text" name="tags" id="tags" placeholder="Tags" value="{{ $tags }}">
            </li>
            <li class="field">
                <label for="status" class="">Status</label>
                <select name="status_id" id="status">
                    @foreach($statuses as $status)
                    <option value="{{ $status->id }}" @if($status->slug == $article->status->slug)selected@endif>{{ $status->status }}</option>
                    @endforeach
                </select>
            </li>
            <li class="field">
                <label for="excerpt" class="inline">Excerpt</label>
                <textarea class="input textarea" placeholder="Excerpt" name="excerpt" id="excerpt" rows="3">{{ $article->excerpt }}</textarea>
            </li>
            <li class="field">
                <label for="content" class="inline">Content</label>
                <textarea class="input textarea" placeholder="Content" name="content" id="content" rows="5">{{ $article->content }}</textarea>
            </li>
        </ul>
        <input type="hidden" name="_method" value="PUT" />
        <input type="hidden" name="id" value="{{ $article->id }}" />
        <div class="medium default btn"><input type="submit" value="Submit"></div>
    </form>
</div>