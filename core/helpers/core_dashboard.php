<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2008 Bharat Mediratta
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street - Fifth Floor, Boston, MA  02110-1301, USA.
 */
class core_dashboard_Core {
  public static function get_list() {
    return array(
      "welcome" => t("Welcome to Gallery 3!"),
      "photo_stream" => t("Photo Stream"),
      "log_entries" => t("Log Entries"),
      "stats" => t("Gallery Stats"),
      "platform_info" => t("Platform Information"),
      "project_news" => t("Gallery Project News"));
  }

  public static function get_block($block_id) {
    $block = new Block();
    switch($block_id) {
    case "welcome":
      $block->id = "gWelcome";
      $block->title = t("Welcome to Gallery3");
      $block->content = new View("admin_block_welcome.html");
      break;

    case "photo_stream":
      $block->id = "gPhotoStream";
      $block->title = t("Photo Stream");
      $block->content = new View("admin_block_photo_stream.html");
      $block->content->photos =
        ORM::factory("item")->where("type", "photo")->orderby("created", "desc")->find_all(10);
      break;

    case "log_entries":
      $block->id = "gLogEntries";
      $block->title = t("Log Entries");
      $block->content = new View("admin_block_log_entries.html");
      $block->content->entries = ORM::factory("log")->orderby("timestamp", "desc")->find_all(5);
        break;

    case "stats":
      $block->id = "gStats";
      $block->title = t("Gallery Stats");
      $block->content = new View("admin_block_stats.html");
      $block->content->album_count = ORM::factory("item")->where("type", "album")->count_all();
      $block->content->photo_count = ORM::factory("item")->where("type", "photo")->count_all();
      break;

    case "platform_info":
      $block->id = "gPlatform";
      $block->title = t("Platform Information");
      $block->content = new View("admin_block_platform.html");
      break;

    case "project_news":
      $block->id = "gProjectNews";
      $block->title = t("Gallery Project News");
      $block->content = new View("admin_block_news.html");
      $block->content->feed = feed::parse("http://gallery.menalto.com/node/feed", 3);
      break;
    }

    return $block;
  }
}