@extends('layouts.app')

@section('content')
    <div style="text-align: center">
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
    </div>


    <div class="container">
        <h2>Generated Images</h2>
        <div class="table-responsive small">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        {{-- <th scope="col">Image</th> --}}
                        <th scope="col">Image</th>
                        <th scope="col">Download</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->created_at->format('d-M-Y / h:ia') }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->description }}</td>
                            {{-- <td>
                                @if ($post->file_path)
                                    <img src="{{ asset('storage/' . $post->file_path) }}" alt="Post Image" width="100">
                                @else
                                    No Image
                                @endif
                            </td> --}}

                            <td>
                                <img src="{{ asset($post->photo_div_id) }}" alt="ScreenShot Image" width="100">
                            </td>



                            <td><button type="button" class="btn btn-success"
                                    onclick="downloadImage('{{ asset($post->photo_div_id) }}')">Download</button></td>
                            <td>
                                <form method="POST" action="{{ route('posts.delete', ['id' => $post->id]) }}">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="b-example-divider"></div>
    <!-- JavaScript for image download -->
    <script>
        function downloadImage(imageUrl) {
            var link = document.createElement('a');
            link.href = imageUrl;
            link.download = 'Post.png';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
@endsection
