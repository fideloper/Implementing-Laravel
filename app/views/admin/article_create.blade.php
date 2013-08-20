<div class="row">
    <form action="/admin/article" method="post">
        <ul>
            <li class="field"><input class="text input" type="text" name="title" placeholder="Title"></li>
            <li class="field"><input class="text input" type="text" name="tags" placeholder="Tags"></li>
            <li class="field">
                <select name="status_id">
                    @foreach($statuses as $status)
                    <option value="{{ $status->id }}"></option>
                    @endforeach
                </select>
            </li>
            <li class="field"><textarea class="input textarea" placeholder="Excerpt" name="excerpt" rows="3"></textarea></li>
            <li class="field"><textarea class="input textarea" placeholder="Content" name="content" rows="5"></textarea></li>
        </ul>
    </form>
</div>