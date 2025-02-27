<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $picture
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category wherePicture($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $code
 * @property string $name
 * @property string $symbol
 * @property int $decimals
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereDecimals($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereSymbol($value)
 */
	class Currency extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $picture
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $currency_code
 * @property-read \App\Models\Currency $currency
 * @property-write mixed $users
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @method static \Database\Factories\LedgerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ledger newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ledger newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ledger query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ledger whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ledger whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ledger whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ledger whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ledger wherePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ledger whereUpdatedAt($value)
 */
	class Ledger extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $ledger_id
 * @property int $user_id
 * @property string|null $deleted_at
 * @property string $aggregate
 * @property-read \App\Models\Ledger $ledger
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LedgerUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LedgerUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LedgerUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LedgerUser whereAggregate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LedgerUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LedgerUser whereLedgerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LedgerUser whereUserId($value)
 */
	class LedgerUser extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $transaction_id
 * @property string $name
 * @property int $index
 * @property int $quantity
 * @property string $cost
 * @property-read mixed $total_cost
 * @property-read \App\Models\ProductOwer|null $pivot
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $owers
 * @property-read int|null $owers_count
 * @property-read \App\Models\Transaction $transaction
 * @property-read \App\Models\Ledger|null $ledger
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereTransactionId($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $product_id
 * @property int $ower_id
 * @property string $aggregate
 * @property-read \App\Models\User $ower
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductOwer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductOwer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductOwer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductOwer whereAggregate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductOwer whereOwerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductOwer whereProductId($value)
 */
	class ProductOwer extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $ledger_id
 * @property string $name
 * @property string|null $location
 * @property \Illuminate\Support\Carbon $datetime
 * @property int|null $category_id
 * @property int $payer_id
 * @property string $cost
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @property-read \App\Models\Ledger $ledger
 * @property-read \App\Models\TransactionOwer|null $pivot
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $owers
 * @property-read int|null $owers_count
 * @property \App\Models\User $payer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Database\Factories\TransactionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereLedgerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction wherePayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereUpdatedAt($value)
 */
	class Transaction extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $transaction_id
 * @property int $ower_id
 * @property string $aggregate
 * @property-read \App\Models\User $ower
 * @property-read \App\Models\Transaction $transaction
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionOwer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionOwer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionOwer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionOwer whereAggregate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionOwer whereOwerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionOwer whereTransactionId($value)
 */
	class TransactionOwer extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $phone_number
 * @property \Illuminate\Support\Carbon|null $phone_number_verified_at
 * @property string|null $picture
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $friends
 * @property-read int|null $friends_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $incoming_friends
 * @property-read int|null $incoming_friends_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ledger> $ledgers
 * @property-read int|null $ledgers_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $outgoing_friends
 * @property-read int|null $outgoing_friends_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhoneNumberVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 */
	class User extends \Eloquent {}
}

