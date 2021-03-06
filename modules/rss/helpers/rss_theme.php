<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2009 Bharat Mediratta
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
class rss_theme_Core {
  static function head($theme) {
    if ($theme->item()) {
      $url = rss::item_feed($theme->item());
    } else if ($theme->tag()) {
      $url = rss::tag_feed($theme->tag());
    }

    if (!empty($url)) {
      return "<link rel=\"alternate\" type=\"" . rest::RSS . "\" href=\"$url\" />";
    }
  }

  static function sidebar_blocks($theme) {
    // @todo this needs to be data driven
    if (!$theme->item()) {
      return;
    }

    $block = new Block();
    $block->css_id = "gRss";
    $block->title = t("Available RSS Feeds");
    $block->content = new View("rss_block.html");
    $block->content->feeds = array(
      t("New photos or movies") => url::site("rss/updates"),
      t("All new comments") => url::site("rss/comments"),
      sprintf(t("Comments on %s"),
              $theme->item()->title) => url::site("rss/comments/{$theme->item()->id}")
    );
    return $block;
  }
}
