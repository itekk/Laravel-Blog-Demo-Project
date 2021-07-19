<?php

// Create Blog
Breadcrumbs::for('create-blogs', function ($trail, $userType) {
    if ($userType == 'admin') {
        $trail->push('Blogs', route('admin-blogs'));
    } elseif ($userType == 'supervisor') {
        $trail->push('Blogs', route('supervisor-blog-list'));
    } else {
        $trail->push('Blogs', route('blogger-list'));
    }
    $trail->push('Create Blog');
});

// Create Blog
Breadcrumbs::for('edit-blogs', function ($trail, $userType) {
    if ($userType == 'admin') {
        $trail->push('Blogs', route('admin-blogs'));
    } elseif ($userType == 'supervisor') {
        $trail->push('Blogs', route('supervisor-blog-list'));
    } else {
        $trail->push('Blogs', route('blogger-list'));
    }
    $trail->push('Edit Blog');
});

// Assigned Bloggers List
Breadcrumbs::for('assigned-bloggers-list', function ($trail) {
    $trail->push('Supervisors', route('admin-supervisor'));
    $trail->push('Assigned Bloggers');
});

// User add
Breadcrumbs::for('add-user', function ($trail) {
    $trail->push('Users', route('admin-users'));
    $trail->push('Add User');
});

// User edit
Breadcrumbs::for('edit-user', function ($trail) {
    $trail->push('Users', route('admin-users'));
    $trail->push('Edit User');
});

// Assign supervisor
Breadcrumbs::for('assign-supervisor', function ($trail) {
    $trail->push('Users', route('admin-users'));
    $trail->push('Assign Supervisors to Bloggers');
});

// Assign bloggers
Breadcrumbs::for('assign-bloggers', function ($trail) {
    $trail->push('Users', route('admin-users'));
    $trail->push('Assign Bloggers to Supervisors');
});

// Assign bloggers
Breadcrumbs::for('change-password', function ($trail, $userType) {
    $trail->push('Dashboard', route($userType . '-dashboard'));
    $trail->push('Change Password');
});
