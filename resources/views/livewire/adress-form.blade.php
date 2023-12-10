<div>
    <h1 class="text-2xl font-semibold mb-4">Address Information</h1>

    <div class="mb-4">
        <label for="deliveryOption" class="block text-sm font-medium text-gray-700">Choose Delivery Option</label>
        <select wire:model="deliveryOption" id="deliveryOption" name="deliveryOption"
                class="mt-1 p-2 border rounded-md w-full">
            <option value="">Choose Delivery Option</option>
            <option value="SundarbanCourier">Sundarban Courier</option>
            <option value="HomeDeliveryInsideDhaka">Home Delivery (Inside Dhaka)</option>
            <option value="HomeDeliveryOutsideDhaka">Home Delivery (Outside Dhaka)</option>
        </select>
    </div>

    @if($deliveryOption === 'SundarbanCourier')
        <div class="text-green-700 mb-4">
            <p>Delivery Charge: 40 Tk</p>
            <p>Please send payment on Bkash or Nagad in 01717893432 (personal) number.</p>
        </div>
    @elseif($deliveryOption === 'HomeDeliveryInsideDhaka')
        <div class="text-green-700 mb-4">
            <p>Delivery Charge: 50 Tk</p>
        </div>
    @elseif($deliveryOption === 'HomeDeliveryOutsideDhaka')
        <div class="text-green-700 mb-4">
            <p>Delivery Charge: 90 Tk</p>
        </div>
    @endif

    <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <input wire:model="name" type="text" id="name" name="name" class="mt-1 p-2 border rounded-md w-full">
    </div>

    <div class="mb-4">
        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
        <input wire:model="phone" type="tel" id="phone" name="phone" class="mt-1 p-2 border rounded-md w-full">
    </div>

    <div class="mb-4">
        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
        <textarea wire:model="address" id="address" name="address" rows="3" class="mt-1 p-2 border rounded-md w-full"></textarea>
    </div>

    <div class="mt-4">
        <button wire:click="placeOrder"
                class="bg-primary text-white px-4 py-2 rounded-md">Place Order
        </button>
    </div>
</div>
