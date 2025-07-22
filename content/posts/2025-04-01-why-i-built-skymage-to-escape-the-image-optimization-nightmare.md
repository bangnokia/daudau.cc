---
title: "Why I built Skymage to escape the image optimization nightmare"
layout: post
tags:
    - skymage
    - image optimization
---

Your website loads in 8 seconds because you uploaded a 4MB hero image. Your mobile users are bouncing before the page finishes loading. You know you need to optimize those images, but the manual workflow is killing you—exporting multiple sizes, creating thumbnails, converting formats, all with messy file names like `img_sm_final_v3.jpg`.

That's why I built Skymage—a simple image optimization API that transforms any image URL into a fast-loading, perfectly-sized version for your website.

## The Image Problem

Images are tricky. They look great until they don't, and then they're massive files slowing down your site. Before Skymage, I'd create multiple versions: thumbnails, mobile sizes, retina copies—all with confusing names like `img_sm_final_v3.jpg`. My projects were messy, hosting costs were high, and I was tired of the process.

I tried existing solutions first. Spatie's Laravel MediaLibrary is solid—I used it for years. But I kept running into limitations:

- **Server Constraints**: It processes images on your own server, which can bring your app to its knees when handling large batches.
- **Framework Lock-in**: It's Laravel-specific. Great if you're in that ecosystem, useless if you're not.
- **Storage Complexity**: You still need to manage cloud storage configuration and CDN integration separately.
- **Limited On-the-Fly Options**: Most transformations need to be pre-defined, not dynamically generated based on real-time needs.

The Spatie team built something great, but I needed more flexibility and something that wouldn't overload my server when processing many images at once. That's why I created [Skymage](https://skymage.dev).

Here's what makes it different:

- **Real-time Resizing**: No more manual export sessions
- **Flexible**: Change sizes instantly without recreating files
- **Clean Projects**: One source image, multiple outputs
- **Better Performance**: Faster sites, happier users

I built this because the existing workflow was too time-consuming.

## How to Use Skymage

Skymage is straightforward—just a URL with parameters. Here's how it works:

### 1. Start with Your Image
Take that large file you need to optimize—like `https://daudau.cc/images/sad-latte.jpg`, a 4MB image. Make sure it's accessible online.

### 2. Add Parameters
Want to resize? Add `?w=500`:

```
https://dau.skymage.net/v1/daudau.cc/images/sad-latte.jpg?w=500
```

Need better compression? Add `q=80`. Want WebP format? Add `f=webp`. Combine them:

```
https://dau.skymage.net/v1/daudau.cc/images/sad-latte.jpg?w=500&q=80&f=webp
```

It's that simple.

### 3. Use It in Your Code
Add it to your HTML:

```html
<img src="https://dau.skymage.net/v1/daudau.cc/images/sad-latte.jpg?w=500&f=webp" alt="Optimized latte image">
```

Or use JavaScript for responsive images:
```javascript
const imgUrl = `https://dau.skymage.net/v1/daudau.cc/images/sad-latte.jpg?w=${window.innerWidth > 768 ? 800 : 400}&f=webp`;
document.querySelector('img').src = imgUrl;
```

### 4. See the Results

Open dev tools and watch that 4MB file become 200KB and load much faster. Pretty satisfying when it works.

## A Real Example

Here's what sparked the idea: I had a photographer client who sent me 20 images, 6MB each. My site took 12 seconds to load. Using Skymage:

```
https://dau.skymage.net/v1/daudau.cc/images/forest.jpg?w=1200&q=85&f=webp
```

Reduced from 6MB to 280KB, load time from 12 seconds to 1.5. The client was happy, and the site performed well.

## Why It Matters

Image optimization isn't just technical—it affects real metrics:

- **User Experience**: Slow sites lose visitors. People expect pages to load under 2 seconds
- **SEO**: Google's Core Web Vitals directly impact search rankings
- **Development Time**: Less time optimizing images means more time building features

I used to dread working with images. Now it's just another tool in the toolkit.

## Affordable Pricing

When building Skymage, I looked at competitors like Cloudinary, Imgix, and Uploadcare. They're powerful but expensive once you scale up.

The pricing reality:

- **Cloudinary**: Great features, but costs add up quickly after the free tier
- **Imgix**: Good free plan, but expensive at scale
- **Uploadcare**: Complex pricing with storage + CDN + transformation fees

Skymage keeps it simple:

- **Simple Pricing**: Pay for bandwidth, that's it
- **Generous Free Tier**: Process thousands of images monthly for free
- **Affordable Scaling**: Our highest tier costs less than competitors' mid-range plans

When a client balked at Cloudinary's $99/month plan, I put them on Skymage for $19/month with the same results.

## What's Next: Platform Integrations

Right now, Skymage works great as a URL-based API, but I know many developers want even simpler integration. I'm planning to build plugins for popular platforms to make image optimization completely seamless:

- **WordPress Plugin**: Auto-optimize images in posts, featured images, and media library uploads
- **PrestaShop Module**: Handle product images, category banners, and theme assets automatically
- **Drupal Module**: Integrate with the media system for automatic optimization

The goal is simple: install a plugin, connect your Skymage account, and never think about image optimization again. Your CMS uploads work as usual, but behind the scenes, all images get optimized automatically.

I'm still figuring out the technical details for each platform—their APIs, hooks, and best practices. If you've built plugins for any of these platforms before, or if there's a specific platform you'd love to see supported, reach out. I'd love to hear your thoughts on what would make these integrations most useful.

## Try It Out

Getting started is simple:

- Visit skymage.dev and sign up (free tier included)
- Test with: https://your-handle.skymage.net/v1/your-domain/images/your-image.jpg?w=600
- Add it to your site and see the performance improvement

Skymage solved my image optimization headaches. It might solve yours too.