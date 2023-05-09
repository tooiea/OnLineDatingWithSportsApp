# OS　使用したいバージョンに合わせて変更
FROM almalinux:8.6

# dnf updateしてkernelなどを最新化する
RUN rpm --import /etc/pki/rpm-gpg/RPM-GPG-KEY-AlmaLinux \
    && dnf update -y \
    && dnf -y install glibc-locale-source glibc-langpack-ja \
    && dnf clean all \
    && rm -rf /var/cache/*

# ロケールと文字コードの設定
RUN localedef -f UTF-8 -i ja_JP ja_JP.UTF-8
ENV LANG="ja_JP.UTF-8" \
    LANGUAGE="ja_JP:ja" \
    LC_ALL="ja_JP.UTF-8"

# タイムゾーンの設定
# httpd、その他必要なモジュールのインストール
RUN ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime\
    && dnf -y install httpd\
    unzip\
    vim

# httpd系の設定ファイル配置
COPY ./httpd/conf/httpd.conf /etc/httpd/conf/

# yum repository追加
# EPEL, remi, mysql ,phpインストール、バージョンに合わせて変更
# 使用したいPHPのモジュールに合わせて変更
RUN dnf install -y epel-release\
    https://rpms.remirepo.net/enterprise/remi-release-8.rpm\
    && dnf config-manager --set-enabled remi\
    && dnf module install -y php:remi-8.1\
    composer\
    && dnf -y install php\
    php-pdo\
    php-mysqlnd\
    && dnf clean all \
    && rm -rf /var/cache/*

# php設定ファイル配置
COPY ./php/php.ini /etc/
COPY ./php/www.conf /etc/php-fpm.d/www.conf

# postfixのインストール
RUN dnf -y install postfix

# httpdの起動設定
RUN systemctl enable httpd

# ポートを公開する
EXPOSE 80

# ワークディレクトリ設定
WORKDIR /var/www/core

# initを起動する
CMD ["/sbin/init"]