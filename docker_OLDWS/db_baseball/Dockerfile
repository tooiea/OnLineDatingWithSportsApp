FROM mysql:8.0-debian

COPY ./conf/my.cnf /etc/mysql/conf.d/my.cnf
COPY ./conf/client.cnf /tmp/client.cnf

RUN chown mysql:mysql /tmp/client.cnf

RUN apt-get update && apt-get install -y locales \
    && sed -i -e 's/# \(ja_JP.UTF-8\)/\1/' /etc/locale.gen \
    && locale-gen \
    && update-locale LANG=ja_JP.UTF-8

ENV LC_ALL ja_JP.UTF-8
ENV TZ Asia/Tokyo
ENV LANG=ja_JP.UTF-8

CMD ["mysqld"]

EXPOSE 3306
