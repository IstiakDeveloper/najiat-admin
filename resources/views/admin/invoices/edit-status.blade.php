<!-- edit-status.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-6 rounded shadow-lg w-96">
            <div class="modal-header mb-4">
                <h5 class="text-xl font-semibold">Change Delivery Status</h5>
            </div>
            <div class="modal-body mb-4">
                <form action="{{ route('invoices.updateStatus', $invoice) }}" method="POST">
                    @csrf

                    <p>Select the new status for this invoice:</p>
                    <div class="flex items-center">
                        <input type="radio" id="statusReview" name="delivery_status" value="Review" {{ old('delivery_status', $invoice->delivery_status) === 'Review' ? 'checked' : '' }}>
                        <label for="statusReview" class="ml-2">Review</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" id="statusPending" name="delivery_status" value="Pending" {{ old('delivery_status', $invoice->delivery_status) === 'Pending' ? 'checked' : '' }}>
                        <label for="statusPending" class="ml-2">Pending</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" id="statusComplete" name="delivery_status" value="Complete" {{ old('delivery_status', $invoice->delivery_status) === 'Complete' ? 'checked' : '' }}>
                        <label for="statusComplete" class="ml-2">Complete</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" id="statusCancel" name="delivery_status" value="Cancel" {{ old('delivery_status', $invoice->delivery_status) === 'Cancel' ? 'checked' : '' }}>
                        <label for="statusCancel" class="ml-2">Cancel</label>
                    </div>

                    <div class="modal-footer mt-4">
                        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">Change Status</button>
                    </div>
                </form>
                @if ($errors->any())
        <div class="mt-4">
            <div class="text-red-500 text-sm">
                Please correct the following errors:
            </div>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

            </div>
        </div>
    </div>
</div>
@endsection
