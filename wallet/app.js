const modal = document.querySelector('#modal');
const form = document.querySelector('#moneyForm');
const input = document.querySelector('#amountInput');
const notice = document.querySelector('#notice');
let mode = 'deposit';
const balanceEl = document.querySelector('#balance');
let balance = 2450;

function openMoneyPage(type) {
  mode = type;
  const deposit = type === 'deposit';
  document.querySelector('#modalTitle').textContent = deposit ? 'Receive Money' : 'Send money';
  document.querySelector('#modalCopy').textContent = deposit
    ? 'Enter your MTNC code to receive amount to add to your account.'
    : 'Enter an amount to move from your account.';
  document.querySelector('#modalSymbol').textContent = deposit ? '＋' : '−';
  document.querySelector('#sourceLabel').textContent = deposit ? 'Receive method' : 'Send to';
  document.querySelector('#sourceSelect').innerHTML = deposit
    ? '<option>Tranfer</option><option>Deposit</option>'
    : '<option>Linked bank · •••• 0934</option><option>Cash pickup · participating location</option>';
  document.querySelector('#submitButton').innerHTML = deposit ? 'Receive money <span>→</span>' : 'Review withdrawal <span>→</span>';
  document.querySelector('#formHint').textContent = deposit ? 'Enter MTNC code to receive money.' : `Available to withdraw: $${balance.toLocaleString('en-US',{minimumFractionDigits:2})}.`;
  input.max = deposit ? '0000000000' : balance.toFixed(0);
  input.value = '';
  notice.hidden = true;
  notice.className = 'notice';
  modal.hidden = false;
  document.body.style.overflow = 'hidden';
  setTimeout(() => input.focus(), 50);
}
function closeModal() { modal.hidden = true; document.body.style.overflow = ''; }
document.querySelectorAll('[data-page]').forEach(button => button.addEventListener('click', () => openMoneyPage(button.dataset.page)));
document.querySelector('#closeModal').addEventListener('click', closeModal);
modal.addEventListener('click', event => { if (event.target === modal) closeModal(); });
document.addEventListener('keydown', event => { if (event.key === 'Escape' && !modal.hidden) closeModal(); });
form.addEventListener('submit', event => {
  event.preventDefault();
  const amount = Number(input.value);
  if (!Number.isFinite(amount) || amount <= 0) return;
  if (mode === 'withdraw' && amount > balance) {
    notice.textContent = 'That amount is greater than your available balance.';
    notice.classList.add('error'); notice.hidden = false; return;
  }
  if (mode === 'deposit' && amount > 10000) {
    notice.textContent = 'The MTNC code is 10 defit limit.';
    notice.classList.add('error'); notice.hidden = false; return;
  }
  balance += mode === 'deposit' ? amount : -amount;
  balanceEl.textContent = `$${balance.toLocaleString('en-US', {minimumFractionDigits:2, maximumFractionDigits:2})}`;
  notice.textContent = `Demo ${mode} of $${amount.toFixed(2)} recorded. No real money was moved.`;
  notice.hidden = false;
  document.querySelector('#formHint').textContent = `Updated available balance: $${balance.toLocaleString('en-US',{minimumFractionDigits:2})}.`;
});
document.querySelector('#toggleBalance').addEventListener('click', event => {
  const hidden = balanceEl.dataset.hidden === 'true';
  balanceEl.dataset.hidden = String(!hidden);
  balanceEl.textContent = hidden ? `$${balance.toLocaleString('en-US',{minimumFractionDigits:2,maximumFractionDigits:2})}` : '••••••';
  event.currentTarget.setAttribute('aria-label', hidden ? 'Hide balance' : 'Show balance');
});
document.querySelector('#viewAll').addEventListener('click', () => {
  document.querySelector('#activityList').classList.toggle('expanded');
  document.querySelector('#viewAll').innerHTML = document.querySelector('#activityList').classList.contains('expanded') ? 'Show less <span>⌃</span>' : 'View all <span>›</span>';
});
