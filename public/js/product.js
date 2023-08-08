
// テーブルソート機能
$(function(){
  $('.table').tablesorter();
});

// 非同期削除
$(function() {
  $('.del-btn').click(function(e) {
    e.preventDefault();  
    let deleteConfirm = confirm('削除してよろしいでしょうか？');
    if(deleteConfirm === true) {
      let userId = $(this).attr('data-id');
      let row = $('.table-row[data-id="' + userId + '"]');    
      $.ajax({
        headers: {
          'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: '/delete/' + userId,
        data: {
          id : userId
        },
        dataType: 'json'
      })
      .done(function(data){
        row.hide();
        showMessage(data.message);    
      })
      .fail(function(error){
        console.log('fail');
      }) 
    }       
  });
});
function showMessage(message) {
let messageBox = $('#message-box');
messageBox.find('.alert').remove();
messageBox.append('<div class="alert alert-success">' + message + '</div>');
messageBox.show();
}

// 非同期検索
$(function() {
  $('#search-button').click(function(e){
    e.preventDefault(); 
    let $company = $('.select-box').val();
    let $keyword = $('.keyword-box').val();
    let $min_price = $('.min_price').val();
    let $max_price = $('.max_price').val();
    let $min_stock = $('.min_stock').val();
    let $max_stock = $('.max_stock').val();

    $.ajax({
      headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
      },
      url: '/search',
      type: 'GET', 
      data: { 
              "keyword": $keyword,
              "company": $company,
              "min_price": $min_price,
              "max_price": $max_price,
              "min_stock": $min_stock,
              "max_stock": $max_stock, 
            },
      datatType:'json',

    }).done(function(products){
        console.log('success');
        let table = $('.table tbody');
        table.empty();
        let html = '';
        
        for (let i = 0; i < products.data.length; i++) {
          let id = products.data[i].id;
          let image_path = products.data[i].image_path;
          let name = products.data[i].product_name;
          let price = products.data[i].price;
          let stock = products.data[i].stock;
          let company = products.data[i].company_name;
          html = `
                  <tr class="table-row">
                    <td class="table-data">${id}</td>
                    <td class="table-data"><img width="50px" src="http://localhost/storage/image/${image_path}"/></td>
                    <td class="table-data">${name}</td>                              
                    <td class="table-data">¥${price}</td>
                    <td class="table-data">${stock}</td>
                    <td class="table-data">${company}</td>
                    <td class="table-data"><a class="link-btn" href="/show/${id}">詳細</a>
                      <form class="del-form" method="post" action="{{ route('delete',['id' => $product->id]) }}">
                        <button data-id="{{ $product->id }}" type="submit" class="link-btn del-btn">削除</button>   
                      </form>
                    </td>                            
                    <td class="table-data"><a class="btn" href="/cart/${id}">購入する</a></td>
                  </tr>
                `
          table.append(html);
          }
      }).fail(function(error){
        console.log("fail", error);
      })
  });
});
