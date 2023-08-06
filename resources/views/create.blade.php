<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            新規登録
        </h2>
    </x-slot>

    {{-- 新規作成フォーム --}}
    <div class="create-container">
        <div class="wrapper">
            <form method="post" action="{{ route('store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form">
                    <label>商品名</label>
                    <input class="input" type="text" id="name" name="product_name" name="product_name"/>
                </div>
                <div class="form">
                    <label>価格</label>
                    <input class="input" type="number" id="price" name="price" value="price"/>
                </div>
                <div class="form">
                    <label>在庫数</label>
                    <input class="input" type="number" name="stock" value="stock"/>
                </div>
                <div class="form">
                    <label>メーカー</label>
                    <select name="company_id" id="company">
                        <option hidden>選択してください</option>
                        @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form">
                    <label>商品詳細</label>
                    <textarea name="comment" cols="20" rows="5"></textarea>
                </div>
                <div class="form">
                    <label>イメージ</label>
                    <input type="file" name="image_path" id="image_path">
                </div>   
                <div>
                    <button type="submit" class="btn">登録</button>   
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
        <button class="link-btn" onclick="location.href='{{ route('index') }}'">一覧へ戻る</button>
    </div>


</x-app-layout>