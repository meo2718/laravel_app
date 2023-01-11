<p>決済ページへリダイレクトします。</p>
{{-- stripeの読み込み --}}
<script src="https://js.stripe.com/v3/"></script>
<script>
  // コントローラからpublicKey取得
const publicKey = '{{ $publicKey }}'
const stripe = Stripe(publicKey)
// 画面を読み込んだ瞬間実行
window.onload = function(){
  stripe.redirectToCheckout({
    // session->idで商品情報をstripeへ飛ばす
    sessionId:'{{ $session->id }}'}).then(function (result) {
    // エラーが発生した場合の遷移先
    window.location.href = '{{ route('user.cart.index') }}';
  });
}
</script>