@foreach ($category->data as $item)
    {{ $item->name }} <br>
@endforeach

<a href="{{ $category->next_page_url }}">Next Page</a>
{{-- {{ $category->links() }} --}}
