<div>
    @props(['role'])

@php
    $classes = "px-2 py-1 text-xs font-medium rounded-full capitalize ";

    switch($role->name) {
        case 'admin':
            $classes .= "bg-red-100 text-red-800 border border-red-200";
            break;
        case 'employer':
            $classes .= "bg-green-100 text-green-800 border border-green-200";
            break;
        case 'job-seeker':
            $classes .= "bg-blue-100 text-blue-800 border border-blue-200";
            break;
        case 'candidate':
            $classes .= "bg-purple-100 text-purple-800 border border-purple-200";
            break;
        case 'moderator':
            $classes .= "bg-yellow-100 text-yellow-800 border border-yellow-200";
            break;
        case 'recruiter':
            $classes .= "bg-indigo-100 text-indigo-800 border border-indigo-200";
            break;
        default:
            $classes .= "bg-red-100 text-gray-800 border border-gray-200";
    }
@endphp

<span class="{{ $classes }}">
    {{ str_replace('_', ' ', $role->name) }}
</span>
</div>
