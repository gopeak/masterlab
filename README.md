# Masterlab


## Improve

项目列表 https://www.processon.com/diagrams/new#temp-system



## vhost.conf update:
`<VirtualHost *:80>
 
     DocumentRoot "c:/www/hornet/app/public"
     ServerName  masterlab.ink   
     <Directory />    
         Options Indexes FollowSymLinks
         AllowOverride All      
         Allow from All     
     </Directory>    
     <Directory "c:/www/hornet/app/public">    
         Options  Indexes FollowSymLinks    
         AllowOverride All    
         Order allow,deny    
         Allow from All    
     </Directory>    
 	
 	Alias /attachment "c:/www/hornet/app/storage/attachment" 
 	<Directory "c:/www/hornet/app/storage/attachment">
 		Options Indexes FollowSymLinks
 		AllowOverride All
 		Order allow,deny
 		Allow from all
 	</Directory>  
  </VirtualHost>
  `
 