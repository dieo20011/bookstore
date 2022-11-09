function load(urlMain) {
        function load_data(url, page, column="ID", byOrder="asc"){
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
            url: url,
            method:"POST",
            data:{
                page: page,
                column: column,
                byOrder: byOrder
            },
            success : function(data){     
                $('.table-responsive').html(data);
            }
    
            });
        }   

        // pagination
            $(document).on('click', 'a.page-link', function (e){
                e.preventDefault();
                var pageId = $(this).attr('page'); 
                var listLink = $('a.page-link');
                var totalPgae = 1;
                $.each(listLink, function (index, value) {
                    $(value).parent().removeClass("active")
                    totalPgae = index;
                    if(pageId == index) {
                        $(value).parent().addClass("active");
                    }
                  });
                if(pageId > 1) {
                    $('li.Previous').children().attr( "page", pageId - 1);
                    $('li.Previous').removeClass('disabled');

                } else {
                    $('li.Previous').children().attr( "page", 0);
                    $('li.Previous').addClass('disabled');
                }
                if(Number(pageId)+1 < totalPgae) {
                    $('li.Next').children().attr( "page", Number(pageId) + 1);
                    $('li.Next').removeClass('disabled');

                } else {
                    $('li.Next').children().attr( "page", pageId);
                    $('li.Next').addClass('disabled');
                }
                var url = urlMain;
                load_data(url , pageId);
                
            });

        // sort 
        $(document).on('click', 'th.sortKey', function(e) {
            e.preventDefault()
            
            var column = $(this).attr('column')
            var byOrder = $(this).attr('byOder')
           
            var pageId = $('li.page-item.active').children().attr("page")
            var url = urlMain;
            load_data(url , pageId, column, byOrder);
            
            byOrder = $(this).attr('byOder')

            if(byOrder == 'asc') {

                $(this).attr('byOder', 'desc')

                byOrder = $(this).attr('byOder')

            } else {

                $(this).attr('byOder', 'asc')

                byOrder = $(this).attr('byOder')

            }
        })
}