<?php

/**
 *
 * For a full API documentation including all parameters, return values, etc, check out:
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
$put->files->create_dir($folderName, $parentID);
$put->files->info($fileID);
$put->files->rename($fileID, $newName);
$put->files->move($fileID, $parentID);
$put->files->delete($fileID);
$put->files->search($queryString);
$put->files->dirmap();

/**
 * Dashboard messages
 *
**/
$put->messages->list();
$put->messages->delete($messageID);

/**
 * Active transfers methods
 *
**/
$put->transfers->list();
$put->transfers->cancel($transferID);
$put->transfers->add([$url1, $url2, $url3]);

/**
 * URL handler methods
 *
**/
$put->urls->analyze([$url1, $url2, $url3]);
$put->urls->extracturls($HTMLorText);

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
$put->subscriptions->create($title, $url, $doFilters, $dontFilters, $parentID, $pause);
$put->subscriptions->edit($subscriptionID, $newTitle, $newURL);
$put->subscriptions->delete($subscriptionID);
$put->subscriptions->pause($subscriptionID);
$put->subscriptions->info($subscriptionID);


?>