# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/lumen-framework/v/unstable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## 将 lumen 的 Artisan 命令和 Swoole 的 task 任务结合

通过结合 lumen 框架的 commands 来实现的 swoole task 模式

### 开启 Swoole 服务

进入 artisan 目录, 执行 `php artisan start_swoole_serve` 

若是要开启常驻进程, 请执行 `screen php artisan start_swoole_task_serve`

### 用 swoole_client 向服务端发起请求

进入  artisan 目录, 指令是 `swoole_client_worker`, 这个指令有一个参数, 是其他的 artisan 指令, 指令之后带上一个 : 即可传入参数, 当前支持传入一个参数, 需要多个参数请自行修改。

执行 `php artisan start_swoole_serve test_command:my_arg`, 则这个指令将向 Swoole 服务器发出执行 test_command 的请求。

## 将 lumen 的 Artisan 命令和 Swoole 的 socket 任务结合

进入 artisan 目录, 执行 `php artisan start_swoole_socket_server` 开启swoole socket 服务器

访问 ` http://host/v1/chat/chatRoom ` 进入聊天室体验页面