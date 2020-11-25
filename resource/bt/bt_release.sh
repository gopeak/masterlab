# 一键生成宝塔的安装文件，有个bug: .htaccess 文件不能打包到里面去

# 先清除数据
rm -rf ./masterlab
rm -rf ./masterlab-3.0
rm -f  ./masterlab-bt-last.zip
rm -rf ./vendor

git clone git@github.com:gopeak/masterlab.git masterlab-3.0

cd masterlab-3.0
# git pull
git checkout master
git pull origin master
git archive --format zip --output "./masterlab-3.0.zip" master -0
cp -f ./masterlab-3.0.zip ../
cd ../
unzip ./masterlab-3.0.zip -d masterlab
cd  masterlab

# 解压composer类库
unzip ./vendor.zip
rm -f ./vendor.zip

# 拷贝宝塔相关文件
cp -f ./public/install/data/main.sql ./import.sql
cat ./public/install/data/demo.sql >> ./import.sql
cp -f ./resource/bt/config.bt.yml ./config.yml
cp -f ./resource/bt/replace.php ./replace.php
cp -f ./resource/bt/install.sh ./install.sh
cp -f ./resource/bt/auto_install.json ./auto_install.json
rm -f ./composer.json
touch  ./public/install/lock

# 增加masterlab_socket
#cp -rf ../bin ./


zip -r  masterlab-bt-last.zip ./*
cp -f ./masterlab-bt-last.zip ../
cd ../

#rm -rf ./masterlab
#rm -rf ./masterlab-3.0

cp -f ./masterlab-bt-last.zip /data/www/masterlab_site/ant/downloads/masterlab-bt-last.zip
cp -f ./masterlab-bt-last.zip /data/www/masterlab_site/ant/downloads/masterlab-bt-v3.0.zip

