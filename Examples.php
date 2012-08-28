<?php

/**
 *
 * For a full API documentation including all parameters, etc, check out:
 * https://put.io/service/api/server
 *
 * For your API key and secret, log into put.io, and go to:
 * https://put.io/user/settings
 *
**/


$put = new PutIO('api_key', 'api_secret');

/**
 * File methods
 *
**/
$put->files->list();
$put->files->create_dir(['name' => 'My Folder', 'parent_id' => 1234]);
$put->files->info(['id' => 1234]);
$put->files->rename(['id' => 1234, 'name' => 'New name']);
$put->files->move(['id' => 1234, 'parent_id' => 5678]);
$put->files->delete(['id' => 1234]);
$put->files->search(['query' => 'my query']);
$put->files->dirmap();

/**
 * Dashboard messages
 *
**/
$put->messages->list();
$put->messages->delete(['id' => 1234]);

/**
 * Active transfers methods
 *
**/
$put->transfers->list();
$put->transfers->cancel(['id' => 1234]);
$put->transfers->add(['links' => ['link 1', 'link 2', 'link 3']]);

/**
 * URL handler methods
 *
**/
$put->urls->analyze(['urls' => ['url 1', 'url 2', 'url 3']]);
$put->urls->extracturls(['txt' => 'Text with URLs']);

/**
 * User methods
 *
**/
$put->user->info();
$put->user->friends();
$put->user->acctoken();

/**
 * Subscription methods
 *
**/
$put->subscriptions->list();
$put->subscriptions->create(['title' => 'My title', 'url' => 'My URL', 'do_filters' => 'Filters', 'dont_filters' => 'Filters', 'parent_folder_id' => 1234, 'paused' => '']);
$put->subscriptions->edit(['id' => 1234, 'title' => 'My title', 'url' => 'My URL']);
$put->subscriptions->delete(['id' => 1234]);
$put->subscriptions->pause(['id' => 1234]);
$put->subscriptions->info(['id' => 1234]);


?>