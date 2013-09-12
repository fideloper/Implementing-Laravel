<div class="row">
<table class="striped rounded">
    <caption>Articles</caption>
    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Status</th>
        <th>Published On</th>
        <th>Updated On</th>
      </tr>
    </thead>
    <tbody>
      @foreach($articles as $article)
      <tr>
        <td>{{ $article->id }}</td>
        <td><a href="/admin/article/{{ $article->id }}/edit">{{ $article->title }}</a></td>
        <td>{{ $article->status->status }}</td>
        <td>{{ $article->created_at }}</td>
        <td>{{ $article->updated_at }}</td>
      </tr>
      @endforeach
    </tbody>
</table>
</div>
<div class="row">
    {{ $articles->links() }}
</div>