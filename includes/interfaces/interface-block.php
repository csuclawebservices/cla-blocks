<?php

/**
 * Block interface
 *
 * @since 0.1.0
 */

namespace cla_blocks\includes\interfaces;

interface Block {
	public function enqueue_block_assets();
	public function enqueue_block_editor_assets();
    public function register_block_type();
	public function render_block($attributes, $content, $block_instance);
    public function render_callback($attributes, $content, $block_instance);
}