<?php use \Illuminate\Support\Str; ?>
<?php if (isset($component)) { $__componentOriginal74daf2d0a9c625ad90327a6043d15980 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal74daf2d0a9c625ad90327a6043d15980 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'laravel-exceptions-renderer::components.card','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('laravel-exceptions-renderer::card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<div class="mt-6">
    <div class="text-xl font-bold lg:text-2xl mb-4">Request Information</div>

    <div class="bg-white overflow-hidden shadow-sm rounded-lg divide-y divide-gray-200">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg font-medium text-gray-900">Method and Path</h3>
            <p class="mt-1 text-sm text-gray-500">
                <?php echo e($exception->request()?->method()); ?>

                <?php echo e($exception->request()?->path() ? '/' . ltrim($exception->request()->path(), '/') : ''); ?>

            </p>
        </div>

    <div class="mt-4">
        <span class="font-semibold text-gray-900 dark:text-white">Headers</span>
    </div>

    <dl class="mt-1 grid grid-cols-1 rounded border dark:border-gray-800">
        <?php if(count($exception->requestHeaders()) > 0): ?>
            <?php $__currentLoopData = $exception->requestHeaders(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center gap-2 <?php echo e($loop->first ? '' : 'border-t'); ?> dark:border-gray-800">
                    <span
                        data-tippy-content="<?php echo e($key); ?>"
                        class="lg:text-md w-[8rem] flex-none cursor-pointer truncate border-r px-5 py-3 text-sm dark:border-gray-800 lg:w-[12rem]"
                    >
                        <?php echo e($key); ?>

                    </span>
                <span
                    class="min-w-0 flex-grow"
                    style="
                        -webkit-mask-image: linear-gradient(90deg, transparent 0, #000 1rem, #000 calc(100% - 3rem), transparent calc(100% - 1rem));
                    "
                >
                    <pre class="scrollbar-hidden overflow-y-hidden text-xs lg:text-sm"><code class="px-5 py-3 overflow-y-hidden scrollbar-hidden max-h-32 overflow-x-scroll scrollbar-hidden-x"><?php echo e($value); ?></code></pre>
                </span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <span class="min-w-0 flex-grow p-4">
                <pre class="text-sm text-gray-500">No headers data</pre>
            </span>
        <?php endif; ?>
    </dl>

    <div class="mt-4">
        <span class="font-semibold text-gray-900 dark:text-white">Body</span>
    </div>

    <div class="mt-1 rounded border dark:border-gray-800">
        <div class="flex items-center">
            <span
                class="min-w-0 flex-grow"
                style="-webkit-mask-image: linear-gradient(90deg, transparent 0, #000 1rem, #000 calc(100% - 3rem), transparent calc(100% - 1rem))"
            >
                <pre class="scrollbar-hidden mx-5 my-3 overflow-y-hidden text-xs lg:text-sm"><code class="overflow-y-hidden scrollbar-hidden overflow-x-scroll scrollbar-hidden-x"><?php echo e($exception->requestBody() ?? 'No body data'); ?></code></pre>
            </span>
        </div>
    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal74daf2d0a9c625ad90327a6043d15980)): ?>
<?php $attributes = $__attributesOriginal74daf2d0a9c625ad90327a6043d15980; ?>
<?php unset($__attributesOriginal74daf2d0a9c625ad90327a6043d15980); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal74daf2d0a9c625ad90327a6043d15980)): ?>
<?php $component = $__componentOriginal74daf2d0a9c625ad90327a6043d15980; ?>
<?php unset($__componentOriginal74daf2d0a9c625ad90327a6043d15980); ?>
<?php endif; ?>

<?php if (isset($component)) { $__componentOriginal74daf2d0a9c625ad90327a6043d15980 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal74daf2d0a9c625ad90327a6043d15980 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'laravel-exceptions-renderer::components.card','data' => ['class' => 'mt-6 overflow-x-auto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('laravel-exceptions-renderer::card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-6 overflow-x-auto']); ?>
    <div>
        <span class="text-xl font-bold lg:text-2xl">Application</span>
    </div>

    <div class="mt-4">
        <span class="font-semibold text-gray-900 dark:text-white"> Routing </span>
    </div>

    <dl class="mt-1 grid grid-cols-1 rounded border dark:border-gray-800">
        <?php if(count($exception->applicationRouteContext()) > 0): ?>
            <?php $__currentLoopData = $exception->applicationRouteContext(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center gap-2 <?php echo e($loop->first ? '' : 'border-t'); ?> dark:border-gray-800">
                    <span class="lg:text-md w-[8rem] flex-none truncate border-r px-5 py-3 text-sm dark:border-gray-800 lg:w-[12rem]">
                        <?php echo e($name); ?>

                    </span>
                    <span class="min-w-0 flex-grow px-5 py-3">
                        <pre class="text-xs lg:text-sm overflow-x-auto"><code><?php echo e($value); ?></code></pre>
                    </span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <span class="min-w-0 flex-grow p-4">
                <pre class="text-sm text-gray-500">No routing data</pre>
            </span>
        <?php endif; ?>
    </dl>

    <?php if($routeParametersContext = $exception->applicationRouteParametersContext()): ?>
        <div class="mt-4">
            <span class="text-gray-900 dark:text-white text-sm"> Routing Parameters </span>
        </div>

        <div class="mt-1 rounded border dark:border-gray-800">
            <div class="flex items-center">
                <span
                    class="min-w-0 flex-grow"
                    style="-webkit-mask-image: linear-gradient(90deg, transparent 0, #000 1rem, #000 calc(100% - 3rem), transparent calc(100% - 1rem))"
                >
                    <pre class="scrollbar-hidden mx-5 my-3 overflow-y-hidden text-xs lg:text-sm"><code class="overflow-y-hidden scrollbar-hidden overflow-x-scroll scrollbar-hidden-x"><?php echo e($routeParametersContext); ?></code></pre>
                </span>
            </div>
        </div>
    <?php endif; ?>

    <div class="mt-4">
        <span class="font-semibold text-gray-900 dark:text-white"> Database Queries </span>
        <span class="text-xs text-gray-500 dark:text-gray-400">
            <?php if(count($exception->applicationQueries()) === 100): ?>
                only the first 100 queries are displayed
            <?php endif; ?>
        </span>
    </div>

    <dl class="mt-1 grid grid-cols-1 rounded border dark:border-gray-800">
        <?php
            $queries = $exception->applicationQueries();
            $hasQueries = !empty($queries);
        ?>
        <?php if($hasQueries): ?>
            <?php $__currentLoopData = $queries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $query): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $connectionName = $query['connectionName'] ?? 'default';
                    $sql = $query['sql'] ?? 'N/A';
                    $time = isset($query['time']) ? $query['time'] . ' ms' : '';
                    $isFirst = $loop->first;
                ?>
                <div class="flex items-center gap-2 <?php echo e($isFirst ? '' : 'border-t'); ?> dark:border-gray-800">
                    <div class="lg:text-md w-[8rem] flex-none truncate border-r px-5 py-3 text-sm dark:border-gray-800 lg:w-[12rem]">
                        <span><?php echo e($connectionName); ?></span>
                        <?php if($time): ?>
                            <span class="hidden text-xs text-gray-500 lg:inline-block">(<?php echo e($time); ?>)</span>
                        <?php endif; ?>
                    </div>
                    <span class="min-w-0 flex-grow px-5 py-3">
                        <pre class="text-xs lg:text-sm overflow-x-auto"><code><?php echo e($sql); ?></code></pre>
                    </span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <?php if (! ($hasQueries)): ?>
            <div class="p-4">
                <pre class="text-sm text-gray-500">No query data</pre>
            </div>
        <?php endif; ?>
    </dl>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal74daf2d0a9c625ad90327a6043d15980)): ?>
<?php $attributes = $__attributesOriginal74daf2d0a9c625ad90327a6043d15980; ?>
<?php unset($__attributesOriginal74daf2d0a9c625ad90327a6043d15980); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal74daf2d0a9c625ad90327a6043d15980)): ?>
<?php $component = $__componentOriginal74daf2d0a9c625ad90327a6043d15980; ?>
<?php unset($__componentOriginal74daf2d0a9c625ad90327a6043d15980); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\cesodo4\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/renderer/components/context.blade.php ENDPATH**/ ?>