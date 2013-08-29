<div class="row">
    <form action="/admin/article" method="post">
        <ul>
            <li class="field">
                <label for="title" class="inline">Title</label>
                <input class="text input" type="text" name="title" id="title" placeholder="Title">
            </li>
            <li class="field">
                <label for="tags" class="inline">Tags</label>
                <input class="text input" type="text" name="tags" id="tags" placeholder="Tags">
            </li>
            <li class="field">
                <label for="status" class="">Status</label>
                <select name="status_id" id="status">
                    @foreach($statuses as $status)
                    <option value="{{ $status->id }}">{{ $status->status }}</option>
                    @endforeach
                </select>
            </li>
            <li class="field">
                <label for="excerpt" class="inline">Excerpt</label>
                <textarea class="input textarea" placeholder="Excerpt" name="excerpt" id="excerpt" rows="3"></textarea>
            </li>
            <li class="field">
                <label for="content" class="inline">Content</label>
                <textarea class="input textarea" placeholder="Content" name="content" id="content" rows="5"></textarea>
            </li>
        </ul>
    </form>
</div>