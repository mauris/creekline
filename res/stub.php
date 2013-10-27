#!/usr/bin/env php
<?php
/**
 * Creekline
 * By Sam-Mauris Yong
 *
 * Released open source under New BSD 3-Clause License.
 * Copyright (c) Sam-Mauris Yong Shan Xian <sam@mauris.sg>
 * All rights reserved.
 */

Phar::mapPhar('creekline.phar');
require 'phar://creekline.phar/bin/creekline';

__HALT_COMPILER();
