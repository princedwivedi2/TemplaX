@extends('layouts.app-dashboard')

@section('title', 'Business Cards')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Business Cards</h5>
            <a href="{{ route('cards.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>New Card
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Job Title</th>
                            <th>Company</th>
                            <th>Template</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cards as $card)
                        <tr>
                            <td>{{ $card->full_name }}</td>
                            <td>{{ $card->job_title }}</td>
                            <td>{{ $card->company_name }}</td>
                            <td class="text-capitalize">{{ $card->template }}</td>
                            <td>{{ $card->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('cards.preview', $card) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Preview
                                </a>
                                <a href="{{ route('cards.edit', $card) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('cards.destroy', $card) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this card?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No business cards found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 