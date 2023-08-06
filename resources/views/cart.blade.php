<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            購入画面
        </h2>
    </x-slot>
    
    {{-- 購入ページ --}}
    <div class="show-container">
        <div class="wrapper">
            <form method="post" action="{{ route('purchase', ['id' => $product->id]) }}" enctype="multipart/form-data">  
                @csrf              
                <div>
                    <img class="purchase-img" src="{{ asset('storage/image/' . $product->image_path) }}">
                </div>
                <div class="purchase-name">
                    {{ $product->id }}. {{ $product->product_name }} (¥{{ $product->price }})
                </div>

                <div class="purchase">
                    @if ($product->stock > 0)
                    <input type="number" name="quantity" min="1"> 
                    <button class="purchase-btn" type="submit">購入する</button>
                    @else
                    <p>※在庫がありません</p>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="back-page">
        <button class="link-btn" onclick="location.href='{{ route('index') }}'">一覧へ戻る</button>
    </div>
</x-app-layout>