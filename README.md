# ACF Gutenberg Demo Theme

A quick naked theme to demonstrate how you can use ACF to create blocks coupled with ACF.

# Files

I have found a useful structure for working with ACF and Gutenberg to be

- [TGM Plugin Activation](https://github.com/TGMPA/TGM-Plugin-Activation) to force ACF install/activate ( `/includes` directory)
- ACF JSON support for versioning and so you deploy changes to production from staging or development without having to update the database. ( `/includes/acf.php` to add support `/acf-json` to store JSON )
- Blocks stored in `/blocks` with preview files using the same filename in `/blocks/previews`

# Creating a New Block

 1. Within `/includes/acf.php` clone or create a new block function on acf/init. 
 2. Allow the function within  `acf_restrict_default_block_types` (e.g. add '`acf/newblock`' to `$allowed_blocks`)
 3. Create a new block file that uses the same filename referenced in `acf/newblock` (e.g. add `/blocks/newblock.php` to `/blocks` ). Create supporting fields as either JSON or within the ACF WP backend. 
 4. Add small preview image from your design or screenshot finished block to `/blocks/previews` with the same filename (e.g. `/blocks/previews/newblock.jpg`)

