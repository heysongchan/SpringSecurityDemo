<?php

/*
 * 该类主要用于用户密码的加密
 * 通过盐值加密，其只有加密没有解密，对应生成的盐值将被存入到数据库中
 */
class passcrpt
{

    /*
     * salt 为对应的盐值,通过uuid获取唯一数
     */
    public static function crpt($password, $salt)
    {
        return crypt($password, $salt);
    }

    /*
     * 获取一个随机数盐值
     * Standard DES: rl.3StKT.4T8M
     * Extended DES: _J9..rasmBYk8r9AiWNc
     * MD5: $1$rasmusle$rISCgZzpwk3UhDidwXvin0
     * Blowfish: $2a$07$usesomesillystringfore2uDLvp1Ii2e./U9C8sBjqp8I90dH6hi
     * SHA-256: $5$rounds=5000$usesomesillystri$KqJWpanXZHKq2BOB43TSaYhEWsQ1Lr5QNyPCDH/Tp.6
     * SHA-512: $6$rounds=5000$usesomesillystri$D4IrlXatmP7rx3P3InaxBeoomnAihCKRVQP22JZ6EY47Wc6BkroIuUUBOov1i.S5KPgErtP/EN5mcO.ChWQW21
     * 在 crypt() 函数支持多重散列的系统上，下面的常量根据相应的类型是否可用被设置为 0 或 1：
     *
     * CRYPT_STD_DES - 基于标准 DES 算法的散列使用 "./0-9A-Za-z" 字符中的两个字符作为盐值。在盐值中使用非法的字符将导致 crypt() 失败。
     * CRYPT_EXT_DES - 扩展的基于 DES 算法的散列。其盐值为 9 个字符的字符串，由 1 个下划线后面跟着 4 字节循环次数和 4 字节盐值组成。它们被编码成可打印字符，每个字符 6 位，有效位最少的优先。0 到 63 被编码为 "./0-9A-Za-z"。在盐值中使用非法的字符将导致 crypt() 失败。
     * CRYPT_MD5 - MD5 散列使用一个以 $1$ 开始的 12 字符的字符串盐值。
     * CRYPT_BLOWFISH - Blowfish 算法使用如下盐值：“$2a$”，一个两位 cost 参数，“$” 以及 64 位由 “./0-9A-Za-z” 中的字符组合而成的字符串。在盐值中使用此范围之外的字符将导致 crypt() 返回一个空字符串。两位 cost 参数是循环次数以 2 为底的对数，它的范围是 04-31，超出这个范围将导致 crypt() 失败。
     * CRYPT_SHA256 - SHA-256 算法使用一个以 $5$ 开头的 16 字符字符串盐值进行散列。如果盐值字符串以 “rounds=<N>$” 开头，N 的数字值将被用来指定散列循环的执行次数，这点很像 Blowfish 算法的 cost 参数。默认的循环次数是 5000，最小是 1000，最大是 999,999,999。超出这个范围的 N 将会被转换为最接近的值。
     * CRYPT_SHA512 - SHA-512 算法使用一个以 $6$ 开头的 16 字符字符串盐值进行散列。如果盐值字符串以 “rounds=<N>$” 开头，N 的数字值将被用来指定散列循环的执行次数，这点很像 Blowfish 算法的 cost 参数。默认的循环次数是 5000，最小是 1000，最大是 999,999,999。超出这个范围的 N 将会被转换为最接近的值。
     * http://www.jb51.net/article/61263.htm
     */
    public static function getSalt()
    {
        $salt = "$5$" . substr(md5(uniqid(rand(), true)), 0, 13);
        return $salt;
    }
}
