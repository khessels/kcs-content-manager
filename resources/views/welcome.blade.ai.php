@extends('layouts.public')

@section('content')
    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <h1 class="text-2xl font-bold text-blue-600">kcs cms</h1>
        <nav class="flex flex-wrap justify-center gap-4 text-center">
        <a href="#features" class="text-gray-700 hover:text-blue-600">Features</a>
        <a href="#demo" class="text-gray-700 hover:text-blue-600">Demo</a>
        <a href="#contact" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded">Start Free</a>
        </nav>
    </div>
    </header>

    <!-- Hero -->
    <section class="bg-blue-50 py-20 text-center px-4">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-4xl sm:text-5xl font-bold text-blue-700 mb-4">Create Pages, Manage Remotely, Add I18N.</h2>
        <p class="text-lg sm:text-xl text-gray-700 mb-6">The Headless CMS for Laravel That Feels Like a blend between WordPress and Laravel</p>
        <a href="#demo" class="bg-blue-600 text-white px-6 py-3 rounded shadow hover:bg-blue-700">See It in Action</a>
    </div>
    </section>

    <!-- Features -->
    <section id="features" class="py-16 bg-white px-4">
    <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-12">
        <div>
        <h3 class="text-2xl font-bold text-blue-600 mb-4">WordPress-Like Page Builder (for Laravel)</h3>
        <ul class="space-y-2 text-gray-700">
            <li>✓ Visual editor for pages, sections, and blocks</li>
            <li>✓ Drag-and-drop components</li>
            <li>✓ Reusable templates and content types</li>
        </ul>
        </div>
        <div>
        <h3 class="text-2xl font-bold text-blue-600 mb-4">Seamless Laravel Integration</h3>
        <ul class="space-y-2 text-gray-700">
            <li>✓ Laravel-optimized API</li>
            <li>✓ Blade component ready</li>
            <li>✓ Works with routes and controllers</li>
        </ul>
        </div>
        <div>
        <h3 class="text-2xl font-bold text-blue-600 mb-4">Full i18n Built In</h3>
        <ul class="space-y-2 text-gray-700">
            <li>✓ Side-by-side translation management</li>
            <li>✓ Per-locale publishing</li>
            <li>✓ Translation fallback support</li>
        </ul>
        </div>
        <div>
        <h3 class="text-2xl font-bold text-blue-600 mb-4">Empower Content Teams</h3>
        <ul class="space-y-2 text-gray-700">
            <li>✓ Role-based access control</li>
            <li>✓ Real-time preview</li>
            <li>✓ Publishing schedules and audit trails</li>
        </ul>
        </div>
    </div>
    </section>

    <!-- Summary -->
    <section class="py-20 bg-blue-600 text-white text-center px-4">
    <h3 class="text-3xl sm:text-4xl font-bold mb-4">Start Building Smarter</h3>
    <p class="text-lg sm:text-xl mb-6">Launch flexible, multi-language pages in Laravel—managed entirely by your content team.</p>
    <a href="#contact" class="bg-white text-blue-600 px-6 py-3 rounded hover:bg-gray-100">Start Free</a>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-6 text-center text-sm px-4">
    <p>&copy; 2025 khessels.com. All rights reserved.</p>
    </footer>
@endsection
