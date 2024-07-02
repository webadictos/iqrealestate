<?php

/**
 * Plugin name: FW Festival Blocks
 */

if (!function_exists("wa_blocks_core_register_blocks")) {
    function wa_blocks_core_register_blocks()
    {
        // register_block_type(__DIR__ . "/build/blocks/info-card");
        // register_block_type(__DIR__ . "/build/blocks/wa-places");
        // register_block_type(__DIR__ . "/build/blocks/wa-internal-link");
        // register_block_type(__DIR__ . "/build/blocks/wa-list-items");
        register_block_type(__DIR__ . "/build/blocks/callout");
        // register_block_type(__DIR__ . "/build/blocks/toc");
        // register_block_type(__DIR__ . "/build/blocks/tabla-contenidos");
        // register_block_type(__DIR__ . "/build/blocks/wa-gallery");
        // register_block_type(__DIR__ . "/build/blocks/fwf-contact");
        // register_block_type(__DIR__ . "/build/blocks/fwf-headings");
        // register_block_type(__DIR__ . "/build/blocks/fwf-logos");
        // register_block_type(__DIR__ . "/build/blocks/fwf-profiles");
        // register_block_type(__DIR__ . "/build/blocks/fwf-program");
        register_block_type(__DIR__ . "/build/blocks/wa-slides");
        // register_block_type(__DIR__ . "/build/blocks/fwf-video");
        register_block_type(__DIR__ . "/build/blocks/wa-rotate");
        register_block_type(__DIR__ . "/build/blocks/wa-accordion");
        register_block_type(__DIR__ . "/build/blocks/wa-accordion-item");
        register_block_type(__DIR__ . "/build/blocks/wa-contacto");


    }
}

add_action("init", "wa_blocks_core_register_blocks");
