<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            編集画面
        </h2>
    </x-slot>

    {{-- 編集フォーム --}}
    <div class="create-container">
        <div class="wrapper">
            <form method="post" action="{{ route('update', ['id' => $product->id ]) }}" enctype="multipart/form-data">
                @csrf
                <div class="form">
                    <label>商品 No.{{ $product->id }}</label>
                    <input type="text" id="name" name="product_name" value="{{ $product->product_name }}" class="input"/>
                </div>
                <div class="form">
                    <label>価格</label>
                    <input type="number" id="price" name="price" value="{{ $product->price }}" class="input"/>
                </div>
                <div class="form">
                    <label>在庫数</label>
                    <input type="number" name="stock" value="{{ $product->stock }}" class="input"/>
                </div>
                <div class="form">
                    <label>メーカー</label>
                    <select name="company_id" id="company">
                        <option value="">選択してください</option>
                        @foreach($companies as $company)
                        <option value="{{ $company->id }}" @if($company->id == $product->company_id) selected @endif>{{ $company->company_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form">
                    <label>商品詳細</label>
                    <textarea name="comment" cols="20" rows="5">{{ $product->comment }}</textarea>
                </div>
                <div class="form">
                     <input type="file" name="image_path" id="image_path">
                </div>
                <div class="form">
                    <label>イメージ</label>
                    <img src="{{ asset('storage/image/' . $product->image_path) }}" class="img"/>
                </div>
                <div>
                    <button type="submit" class="btn">更新</button>   
                </div>
                <div>
                    @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </form>
        </div>
    </div>         
    <div class="back-page">
        <button class="link-btn" onclick="location.href = '{{ route('index') }}'">一覧へ戻る</button>
    </div>
</x-app-layout>