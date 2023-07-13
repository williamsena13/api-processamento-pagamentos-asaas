<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('object')->nullable();
            $table->string('dateCreated')->nullable();
            $table->string('customer')->nullable();
            $table->string('paymentLink')->nullable();
            $table->decimal('value', 8, 2)->nullable();
            $table->decimal('netValue', 8, 2)->nullable();
            $table->decimal('originalValue', 8, 2)->nullable();
            $table->decimal('interestValue', 8, 2)->nullable();
            $table->string('description')->nullable();
            $table->string('billingType')->nullable();
            $table->string('pixTransaction')->nullable();
            $table->string('status')->nullable();
            $table->date('dueDate')->nullable();
            $table->date('originalDueDate')->nullable();
            $table->date('paymentDate')->nullable();
            $table->date('clientPaymentDate')->nullable();
            $table->string('installmentNumber')->nullable();
            $table->string('invoiceUrl')->nullable();
            $table->string('invoiceNumber')->nullable();
            $table->string('externalReference')->nullable();
            $table->boolean('deleted')->nullable();
            $table->boolean('anticipated')->nullable();
            $table->boolean('anticipable')->nullable();
            $table->date('creditDate')->nullable();
            $table->date('estimatedCreditDate')->nullable();
            $table->string('transactionReceiptUrl')->nullable();
            $table->string('nossoNumero')->nullable();
            $table->string('bankSlipUrl')->nullable();
            $table->dateTime('lastInvoiceViewedDate')->nullable();
            $table->dateTime('lastBankSlipViewedDate')->nullable();
            $table->boolean('postalService')->nullable();
            $table->string('custody')->nullable();
            $table->string('refunds')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'object',
                'dateCreated',
                'customer',
                'paymentLink',
                'value',
                'netValue',
                'originalValue',
                'interestValue',
                'description',
                'billingType',
                'pixTransaction',
                'status',
                'dueDate',
                'originalDueDate',
                'paymentDate',
                'clientPaymentDate',
                'installmentNumber',
                'invoiceUrl',
                'invoiceNumber',
                'externalReference',
                'deleted',
                'anticipated',
                'anticipable',
                'creditDate',
                'estimatedCreditDate',
                'transactionReceiptUrl',
                'nossoNumero',
                'bankSlipUrl',
                'lastInvoiceViewedDate',
                'lastBankSlipViewedDate',
                'postalService',
                'custody',
                'refunds',
            ]);
        });
    }
}