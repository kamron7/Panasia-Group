# IMAGES NEEDED FOR PANASIA WEBSITE

Place these images in: g:\unidevs\public\assets\public\images\

## Hero Section
- hero-bg.mp4 (video) - in `/videos/` folder
- hero-poster.jpg (fallback image for video)

## Image Breaks (Parallax Sections)
- energy-infrastructure.jpg (Central Asian energy facilities, pipelines, refineries)
- maritime-logistics.jpg (ports, ships, Caspian sea)

## Commodities Cards (6 images)
- crude-oil.jpg (oil fields, crude oil facilities)
- petroleum.jpg (fuel, refinery products)
- natural-gas.jpg (gas pipelines, LNG facilities)
- coal.jpg (coal mining, export facilities)
- fertilizers.jpg (agricultural fertilizers, production)
- metals.jpg (steel, ferrous/non-ferrous metals)

## Why Panasia Cards (4 images)
- why-expertise.jpg (team, expertise, Central Asia map)
- why-trade.jpg (trading floor, supply chain)
- why-europe.jpg (European ports, markets)
- why-partners.jpg (business handshake, partnerships)

## About Page
(No additional images needed - uses CSS gradients as fallback)

---

## Image Specifications:

### Recommended Sizes:
- **Hero Video**: 1920x1080, MP4 format, < 5MB, loop-ready
- **Hero Poster**: 1920x1080, JPG, optimized
- **Image Breaks**: 1920x1080 or 2560x1080 (wide), JPG, high quality
- **Commodity Cards**: 600x800 (vertical) or 800x600, JPG, optimized
- **Why Cards**: 600x400, JPG, optimized

### Optimization Tips:
1. Use TinyPNG or ImageOptim to compress images
2. Keep all images under 200KB where possible
3. Use WebP format with JPG fallback for better performance
4. Ensure images have proper contrast for overlay text

### Fallback:
If images are not available, the CSS gradients (cgrad-*, wgrad-*, igrad-*) will still display as backgrounds.

---

## Files Updated:
1. home.blade.php - Image paths added
2. style.css - Image display styles + fallback gradients

## Next Steps:
1. Add images to /public/assets/public/images/
2. Add video to /public/assets/public/videos/
3. Test on slow connection to verify fallbacks work
4. Consider adding WebP versions for better performance
