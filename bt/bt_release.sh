# 一键生成宝塔的安装文件，有个bug: .htaccess 文件不能打包到里面去

# 先清除数据
rm -rf ./masterlab
rm -rf ./masterlab-2.1.2
rm -f  ./masterlab-bt-last.zip
rm -rf ./vendor

git clone git@github.com:gopeak/masterlab.git masterlab-2.1.2

cd masterlab-2.1.2
# git pull
git checkout 2.1
git pull origin 2.1
git archive --format zip --output "./masterlab-2.1.2.zip" 2.1 -0
cp -f ./masterlab-2.1.2.zip ../
cd ../
unzip ./masterlab-2.1.2.zip -d masterlab
cd  masterlab

# 解压composer类库
unzip ./vendor.zip  
rm -f ./vendor.zip 

# 拷贝宝塔相关文件
cp -f ./app/public/install/data/main.sql ./import.sql
cp -f ./bt/database.cfg.php ./app/config/deploy/database.cfg.php
cp -f ./bt/auto_install.json ./auto_install.json
rm -f ./app/public/install/lock

# 增加masterlab_socket
#cp -rf ../bin ./


zip -r  masterlab-bt-last.zip ./*
cp -f ./masterlab-bt-last.zip ../
cd ../

#rm -rf ./masterlab
#rm -rf ./masterlab-2.1.2

cp -f ./masterlab-bt-last.zip /data/www/masterlab_site/ant/downloads/masterlab-bt-last.zip
cp -f ./masterlab-bt-last.zip /data/www/masterlab_site/ant/downloads/masterlab-bt-v2.1.2.zip

