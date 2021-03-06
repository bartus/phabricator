<?php

/*
 * Copyright 2012 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

final class AphrontPanelView extends AphrontView {

  const WIDTH_FULL = 'full';
  const WIDTH_FORM = 'form';
  const WIDTH_WIDE = 'wide';

  private $buttons = array();
  private $header;
  private $caption;
  private $width;
  private $classes = array();
  private $id;

  public function setCreateButton($create_button, $href) {
    $this->addButton(
      phutil_render_tag(
        'a',
        array(
          'href' => $href,
          'class' => 'button green',
        ),
        $create_button));

    return $this;
  }

  public function addClass($class) {
    $this->classes[] = $class;
    return $this;
  }

  public function addButton($button) {
    $this->buttons[] = $button;
    return $this;
  }

  public function setHeader($header) {
    $this->header = $header;
    return $this;
  }

  public function setWidth($width) {
    $this->width = $width;
    return $this;
  }

  public function setID($id) {
    $this->id = $id;
    return $this;
  }

  public function setCaption($caption) {
    $this->caption = $caption;
    return $this;
  }

  public function render() {
    if ($this->header !== null) {
      $header = '<h1>'.$this->header.'</h1>';
    } else {
      $header = null;
    }

    if ($this->caption !== null) {
      $caption =
        '<div class="aphront-panel-view-caption">'.
          $this->caption.
        '</div>';
    } else {
      $caption = null;
    }

    $buttons = null;
    if ($this->buttons) {
      $buttons =
        '<div class="aphront-panel-view-buttons">'.
          implode(" ", $this->buttons).
        '</div>';
    }
    $header_elements =
      '<div class="aphront-panel-header">'.
        $buttons.$header.$caption.
      '</div>';
    $table = $this->renderChildren();

    require_celerity_resource('aphront-panel-view-css');

    $classes = $this->classes;
    $classes[] = 'aphront-panel-view';
    if ($this->width) {
      $classes[] = 'aphront-panel-width-'.$this->width;
    }

    return phutil_render_tag(
      'div',
      array(
        'class' => implode(' ', $classes),
        'id'    => $this->id,
      ),
      $header_elements.$table);
  }

}
