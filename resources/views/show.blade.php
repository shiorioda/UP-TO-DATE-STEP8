<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            詳細画面
        </h2>
    </x-slot>
    
    {{-- 詳細ページ --}}
    <div class="show-container">
        <div class="wrapper">
            <table class="table">
                <tr><th>商品ID</th><td>No.{{ $product->id }}</td></tr>
                <tr><th>商品名</th><td>{{ $product->product_name }}</td></tr>
                <tr><th>価格</th><td>{{ $product->price }}</td></tr>
                <tr><th>在庫数</th><td>{{ $product->stock }}</td></tr>
                <tr><th>メーカー</th><td>{{ $product->company_name }}</td></tr>
                <tr><th>商品詳細</th><td>{{ $product->comment }}</td></tr>
            </table>
        <div>
            <img class="img" src="{{ asset('storage/image/' . $product->image_path) }}" />
        </div>
        <div>
            <button class="btn" onclick="window.location.href='{{ route('edit', ['id' => $product->id]) }}'">編集</button>
        </div>
    </div>
    <div class="back-page">
        <button class="link-btn" onclick="location.href='{{ route('index') }}'">一覧へ戻る</button>
    </div>    
</x-app-layout>