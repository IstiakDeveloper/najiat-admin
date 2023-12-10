

<div>
    <h1 class="text-2xl font-semibold mb-4">Address Information</h1>

    <div class="mb-4">
        <label for="deliveryOption" class="block text-sm font-medium text-gray-700">Choose Delivery Option</label>
        <select wire:model="deliveryOption" id="deliveryOption" name="deliveryOption" class="mt-1 p-2 border rounded-md w-full" wire:change="deliveryOptionUpdateFunction" required>
            <option value="" >Choose Delivery Option</option>
            <option value="SundarbanCourier">Sundarban Courier (Advance Payment)</option>
            <option value="HomeDeliveryInsideDhaka">Home Delivery (Inside Dhaka)</option>
            <option value="HomeDeliveryOutsideDhaka">Home Delivery (Outside Dhaka)</option>
        </select>
        @error('deliveryOption') <span class="text-red-500">{{ $message }}</span> @enderror
    </div>

    <div id="deliveryChargeInfo" class="text-green-700 mb-4" @if($deliveryCharge) style="display: block;" @else style="display: none;" @endif>
        <p>Delivery Charge: {{ $deliveryCharge }} Tk</p>
        {{-- <p>Total Price: {{ $totalPrice }} Tk</p> --}}
        @if($deliveryOption === 'SundarbanCourier')
            <p>Please send payment on Bkash or Nagad in 01717893432 (personal) number.</p>
        @endif
    </div>

    <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <input wire:model="name" type="text" id="name" name="name" class="mt-1 p-2 border rounded-md w-full" required>
        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
        <input wire:model="phone" type="tel" id="phone" name="phone" class="mt-1 p-2 border rounded-md w-full" required>
        @error('phone') <span class="text-red-500">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
        <textarea wire:model="address" id="address" name="address" rows="3" class="mt-1 p-2 border rounded-md w-full" required></textarea>
        @error('address') <span class="text-red-500">{{ $message }}</span> @enderror
    </div>

    <div class="mt-4">
        <button wire:click="placeOrder" class="bg-purple-500 text-white px-4 py-2 rounded-md">Place Order</button>
    </div>
</div>

