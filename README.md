# PHP-Ziyaretci-Discord-Webhook-Log

>## Websiteye giriş yapan ziyaretçilerin ip, tarayıcı, işletim sistemi, ülke, tarih bilgilerini discorda webhooklu şekilde loglar

 Kullanım için header veya footer dosyanıza alttaki örnek kodu eklemeniz yeterlidir. 
>(Örnek kodda dosyalar girislog klasörünün içindedir!)
```php
	<?php include("girislog/index.php") ?>
```

## Ayarlamanız gereken kısımlar;

>**İndex.php**
-  4.satırdaki kısıma discord webhook urlsini yerleştirmeniz gerekmektedir.
-  80.satır ile 126.satır arasındaki discord webhook mesajını kendinize göre düzenleyebilirsiniz.
