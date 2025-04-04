Nesting ScrollTriggers inside multiple timeline tweens
A very common mistake is applying ScrollTrigger to multiple tweens that are nested inside a timeline. Logic-wise, that can't work. When you nest an animation in a timeline, that means the playhead of the parent timeline is what controls the playhead of the child animations (they all must be synchronized otherwise it wouldn't make any sense). When you add a ScrollTrigger with scrub, you're basically saying "I want the playhead of this animation to be controlled by the scrollbar position"...you can't have both. For example, what if the parent timeline is playing forward but the user also is scrolling backwards? See the problem? It can't go forward and backward at the same time, and you wouldn't want the playhead to get out of sync with the parent timeline's. Or what if the parent timeline is paused but the user is scrolling?

So definitely avoid putting ScrollTriggers on nested animations. Instead, either keep those tweens independent (don't nest them in a timeline) -OR- just apply a single ScrollTrigger to the parent timeline itself to hook the entire animation as a whole to the scroll position.

Creating to() logic issues
If you want to animate the same properties of the same element in multiple ScrollTriggers, it 's common to create logic issues like this:

gsap.to('h1', {
x: 100,
scrollTrigger: {
trigger: 'h1',
start: 'top bottom',
end: 'center center',
scrub: true
}
});

gsap.to('h1', {
x: 200,
scrollTrigger: {
trigger: 'h1',
start: 'center center',
end: 'bottom top',
scrub: true
}
});

Did you catch the mistake? You might think that it will animate the x value to 100 and then directly to 200 when the second ScrollTrigger starts. However if you scroll through the page you 'll see that it animates to 100 then jumps back to 0 (the starting x value) then animates to 200. This is because the starting values of ScrollTriggers are cached when the ScrollTrigger is created.

loading...
To work around this either use set immediateRender: false (like this demo shows) or use .fromTo()s for the later tweens (like this demo shows) or set a ScrollTrigger on a timeline and put the tweens in that timelines instead (like this demo shows).

Using one ScrollTrigger or animation for multiple "sections"
If you want to apply the same effect to multiple sections/elements so that they animate when they come into view, for example, it's common for people to try to use a single tween which targets all the elements but that ends up animating them all at once. For example:

loading...
Since each of the elements would get triggered at a different scroll position, and of course their animations would be distinct, just do a simple loop instead, like this:

loading...
Forgetting to use function-based start/end values for things that are dependent on viewport sizing
For example, let's say you've got a start or end value that references the height of an element which may change if/when the viewport resizes. ScrollTrigger will refresh() automatically when the viewport resizes, but if you hard-coded your value when the ScrollTrigger was created that won't get updated...unless you use a function-based value.

end: `+=${elem.offsetHeight}` // won't be updated on refresh

end: () => `+=${elem.offsetHeight}` // will be updated

Additionally, if you want the animation values to update, make sure the ones you want to update are function-based values and set invalidateOnRefresh: true in the ScrollTrigger.

Start animation mid-viewport, but reset it offscreen
For example try scrolling down then back up in this demo:

loading...
Notice that we want the animation to start mid-screen, but when scrolling backwards we want it to reset at a completely different place (when the element goes offscreen). The solution is to use two ScrollTriggers - one for the playing and one for the resetting once the element is off screen.

loading...
Creating ScrollTriggers out of order
If you have any ScrollTriggers that pin elements (with the default pinSpacing: true) then the order in which the ScrollTriggers are created is important. This is because any ScrollTriggers after the ScrollTrigger with pinning need to compensate for the extra distance that the pinning adds. You can see an example of how this sort of thing might happen in the pen below. Notice that the third box's animation runs before it's actually in the viewport.

loading...
To fix this you can either create the ScrollTriggers in the order in which they are reached when scrolling or use ScrollTrigger's refreshPriority property to tell certain ScrollTriggers to calculate their positions sooner (the higher the refreshPriority the sooner the positions will be calculated). The demo below creates the ScrollTriggers in their proper order.

loading...
Loading new content but not refreshing
All ScrollTriggers get setup as soon as it's reasonably safe to do so, usually once all content is loaded. However if you're loading images that don't have a width or height attribute correctly set or you are loading content dynamically (via AJAX/fetch/etc.) and that content affects the layout of the page you usually need to refresh ScrollTrigger so it updates the positions of the ScrollTriggers. You can do that easily by calling ScrollTrigger.refresh() in the callback for your method that is loading the image or new content.

Why does my "scrub" animation jump on initial load?
Most likely the ScrollTrigger 's start value is before the starting scroll position. This usually happens when the start is something like "top bottom" (the default start value) and the element is at the very top of the page. If you don 't want this to happen simply adjust the start value to one that 's after a scroll position of 0.

How to make "scrub" animations take longer
How to make "scrub" animations take longer
The duration of a "scrub" animation will always be forced to fit exactly between the start and end of the ScrollTrigger position, so increasing the duration value won't do anything if the start and end of the ScrollTrigger stay the same. To make the animation longer, just push the end value down further. For example, instead of end: "+=300", make it "+=600" and the animation will take twice as long.

Check out the docs for more info and a demo.

Navigating back to a page causes ScrollTrigger to break
If you have a single-page application (SPA; i.e. a framework such as React or Vue, a page-transition library like Highway.js, Swup, or Barba.js, or something similar) and you use ScrollTrigger you might run into some issues when you navigate back to a page that you've visited already. Usually this is because SPAs don't automatically destroy and re-create your ScrollTriggers so you need to do that yourself when navigating between pages or components.

To do that, you should kill off any relevant ScrollTriggers in whatever tool you're using's unmount or equivalent callback. Then make sure to re-create any necessary ScrollTriggers in the new component/page's mount or equivalent callback. In some cases when the targets and such still exist but the measurements are incorrect you might just need to call ScrollTrigger.refresh(). If you need help in your particular situation, please make a minimal demo and then create a new thread in our forums along with the demo and an explanation of what's going wrong.
