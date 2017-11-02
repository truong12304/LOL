<? php
/ **
 * Bản quyền năm 2017 zoro12304 <zoro12304@gmail.com>
 * /
không gian tên  zoro12304 ;
lớp  Chatfuel
{
  const  VERSION  =  ' 1.0.0 ' ;
  bảo vệ  $ phản ứng  =  mảng ();
   hàm  công cộng __construct ( $ debug  =  FALSE )
  {
    nếu (( !  $ debug ) && ( !  isset ( $ _SERVER [ ' HTTP_USER_AGENT ' ]) HOẶC  strpos ( $ _SERVER [ ' HTTP_USER_AGENT ' ], ' Apache-HttpAsyncClient ' ) ===  FALSE )) {
      xuất cảnh ;
    }
  }
   chức năng  công cộng __destruct ()
  {
    if ( count ( $ this -> response ) >  0 ) {
      hãy thử {
        header ( ' Content-Type: application / json ' );
        echo  json_encode ( array ( ' messages '  =>  $ this -> response ));
        xuất cảnh ;
      } catch ( ngoại lệ  $ e ) {
        // noop
      }
    }
  }
   hàm  công cộng sendText ( $ message  =  null )
  {
    if ( is_null ( $ messages )) {
      ném  ngoại lệ mới  ( ' Invalid input ' , 1 );
    }
    $ type  =  gettype ( $ message );
    if ( $ type  ===  ' string ' ) {
      $ this -> response [] =  array ( ' text '  =>  $ messages );
    } elseif ( $ type  ===  ' array '  ||  is_array ( $ messages )) {
      foreach ( $ thư  như  $ message ) {
        $ this -> response [] =  array ( ' text '  =>  $ message );
      }
    } else {
      $ this -> response [] =  array ( ' text '  =>  ' Lỗi! ' );
    }
  }
   chức năng  công cộng sendImage ( $ url )
  {
    if ( $ this -> isURL ( $ url )) {
      $ this -> sendAttachment ( ' image ' , array ( ' url '  =>  $ url ));
    } else {
      $ this -> sendText ( ' Lỗi: URL không hợp lệ! ' );
    }
  }
   chức năng  công cộng sendVideo ( $ url )
  {
    if ( $ this -> isURL ( $ url )) {
      $ this -> sendAttachment ( ' video ' , array ( ' url '  =>  $ url ));
    } else {
      $ this -> sendText ( ' Lỗi: URL không hợp lệ! ' );
    }
  }
   chức năng  công cộng sendAudio ( $ url )
  {
    if ( $ this -> isURL ( $ url )) {
      $ this -> sendAttachment ( ' audio ' , array ( ' url '  =>  $ url ));
    } else {
      $ this -> sendText ( ' Lỗi: URL không hợp lệ! ' );
    }
  }
   chức năng  công cộng sendTextCard ( $ văn bản , $ nút )
  {
    if ( is_array ( $ buttons )) {
      $ this -> sendAttachment ( ' mẫu ' , mảng (
        ' template_type '  =>  ' nút ' ,
        ' text '           =>  $ văn bản ,
        nút ' button '        =>  $
      ));
      trả về  TRUE ;
    }
    trả về  FALSE ;
  }
   chức năng  công cộng sendGallery ( $ phần tử )
  {
    if ( is_array ( $ elements )) {
      $ this -> sendAttachment ( ' mẫu ' , mảng (
        ' template_type '  =>  ' chung ' ,
        ' elements '       =>  $ phần tử
      ));
      trả về  TRUE ;
    }
    trả về  FALSE ;
  }
   chức năng  createElement công cộng ( $ title , $ image , $ subTitle , $ buttons )
  {
    if ( $ this -> isURL ( $ image ) &&  is_array ( $ buttons )) {
      trở  mảng (
        ' title '      =>  $ tiêu đề ,
        ' image_url '  =>  $ hình ảnh ,
        ' phụ đề '   =>  $ subTitle ,
        nút ' button '    =>  $
      );
    }
    trả về  FALSE ;
  }
   hàm  công cộng createButtonToBlock ( $ title , $ block , $ setAttributes  =  NULL )
  {
    $ button  =  array ();
    $ button [ ' type ' ] =  ' show_block ' ;
    $ button [ ' title ' ] =  $ title ;
    
    if ( is_array ( $ block )) {
      $ button [ ' block_names ' ] =  $ block ;
    } else {
      $ button [ ' block_name ' ] =  $ block ;
    }
    if ( !  is_null ( $ setAttributes ) &&  is_array ( $ setAttributes )) {
      $ button [ ' set_attributes ' ] =  $ setAttributes ;
    }
     nút trả lại $ ;
  }
   hàm  công cộng createButtonToURL ( $ title , $ url , $ setAttributes  =  NULL )
  {
    if ( $ this -> isURL ( $ url )) {
      $ button  =  array ();
      $ button [ ' type ' ] =  ' web_url ' ;
      $ button [ ' url ' ] =  $ url ;
      $ button [ ' title ' ] =  $ title ;
      
      if ( !  is_null ( $ setAttributes ) &&  is_array ( $ setAttributes )) {
        $ button [ ' set_attributes ' ] =  $ setAttributes ;
      }
       nút trả lại $ ;
    }
    trả về  FALSE ;
  }
   hàm  công cộng createPostBackButton ( $ title , $ url )
  {
    if ( $ this -> isURL ( $ url )) {
      trở  mảng (
        ' url '    =>  $ url ,
        ' type '   =>  ' json_plugin_url ' ,
        ' title '  =>  $ title
      );
    }
    trả về  FALSE ;
  }
   hàm  công cộng createCallButton ( $ phoneNumber , $ title  =  ' Call ' )
  {
    trở  mảng (
      ' type '          =>  ' phone_number ' ,
      ' phone_number '  =>  số điện thoại Số ,
      ' title '         =>  $ title
    );
  }
   hàm  công cộng createShareButton ()
  {
    return  array ( ' type '  =>  ' element_share ' );
  }
   hàm  công cộng createQuickReply ( $ văn bản , $ quickReplies )
  {
    if ( is_array ( $ quickReplies )) {
      $ this -> response [ ' text ' ] =  $ văn bản ;
      $ this -> response [ ' quick_replies ' ] =  $ quickReplies ;
      trả về  TRUE ;
    }
    trả về  FALSE ;
  }
   hàm  công cộng createQuickReplyButton ( $ title , $ block )
  {
    $ button  =  array ();
    $ button [ ' title ' ] =  $ title ;
    if ( is_array ( $ block )) {
      $ button [ ' block_names ' ] =  $ block ;
    } else {
      $ button [ ' block_name ' ] =  $ block ;
    }
     nút trả lại $ ;
  }
  tin  chức năng  sendAttachment ( $ loại , $ trọng tải )
  {
    $ type  =  strtolower ( $ type );
    $ validTypes  =  mảng ( ' hình ảnh ' , ' video ' , ' âm thanh ' , ' mẫu ' );
    if ( in_array ( $ type , $ validTypes )) {
      $ this -> response [] =  array (
        ' attachment '  =>  mảng (
          ' type '     =>  $ loại ,
          ' payload '  =>  $ payload
        )
      );
    } else {
      $ this -> response [] =  array ( ' text '  =>  ' Lỗi: Loại không hợp lệ! ' );
    }
  }
   hàm  riêng isURL ( $ url )
  {
    return  filter_var ( $ url , FILTER_VALIDATE_URL );
  }
}