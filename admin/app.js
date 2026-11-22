const seedCustomers = [
  { id: 1, name: 'Olivia Chen', email: 'olivia.chen@email.com', initials: 'OC', account: '•••• 4829', status: 'Active', date: 'Nov 14, 2026', balance: 24850.75, color: ['#e9efff', '#4667c9'] },
  { id: 2, name: 'Marcus Williams', email: 'marcus.w@email.com', initials: 'MW', account: '•••• 1936', status: 'Active', date: 'Nov 12, 2026', balance: 12740.00, color: ['#eaf5ef', '#3e8c69'] },
  { id: 3, name: 'Priya Patel', email: 'priya.patel@email.com', initials: 'PP', account: '•••• 7502', status: 'Active', date: 'Nov 10, 2026', balance: 38920.50, color: ['#f3eafa', '#8c5eb2'] },
  { id: 4, name: 'James Okafor', email: 'james.okafor@email.com', initials: 'JO', account: '•••• 6148', status: 'Review', date: 'Nov 08, 2026', balance: 5720.25, color: ['#fff1e3', '#c28245'] },
  { id: 5, name: 'Sofia Rodriguez', email: 'sofia.r@email.com', initials: 'SR', account: '•••• 2301', status: 'Active', date: 'Nov 06, 2026', balance: 19680.00, color: ['#e7f4f5', '#498c91'] },
  { id: 6, name: 'Daniel Kim', email: 'daniel.kim@email.com', initials: 'DK', account: '•••• 9057', status: 'Active', date: 'Nov 03, 2026', balance: 31450.80, color: ['#f8eaf0', '#b45779'] },
  { id: 7, name: 'Aisha Bello', email: 'aisha.bello@email.com', initials: 'AB', account: '•••• 3684', status: 'Active', date: 'Oct 29, 2026', balance: 8640.00, color: ['#eeeefe', '#6665a7'] },
  { id: 8, name: 'Ethan Thompson', email: 'ethan.t@email.com', initials: 'ET', account: '•••• 1029', status: 'Review', date: 'Oct 26, 2026', balance: 15230.45, color: ['#edf2e8', '#6e8e4b'] }
];

const money = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' });
const dateNow = new Intl.DateTimeFormat('en-US', { month: 'short', day: '2-digit', year: 'numeric' }).format(new Date());
const storageKey = 'northstar-admin-customers-v1';
let customers = loadCustomers();
let activities = [
  { icon: '↓', type: 'deposit', title: 'Deposit received', detail: 'Olivia Chen · Today, 10:42 AM', amount: '+$2,500.00' },
  { icon: '⇄', type: 'transfer', title: 'Transfer completed', detail: 'Priya Patel · Today, 10:18 AM', amount: '−$840.00' },
  { icon: '◷', type: 'review', title: 'Account flagged for review', detail: 'James Okafor · Today, 9:56 AM', amount: '' }
];
const $ = (selector) => document.querySelector(selector);
const rows = $('#customerRows');
const dialog = $('#depositDialog');
const toast = $('#toast');
let toastTimeout;

function loadCustomers() {
  try {
    const saved = JSON.parse(localStorage.getItem(storageKey));
    if (Array.isArray(saved) && saved.length) return saved;
  } catch (_) { /* Start with the sample accounts when storage is unavailable. */ }
  return seedCustomers.map(customer => ({ ...customer, color: [...customer.color] }));
}

function saveCustomers() {
  try { localStorage.setItem(storageKey, JSON.stringify(customers)); } catch (_) { /* The demo remains usable without browser storage. */ }
}

function render() {
  const query = $('#searchInput').value.trim().toLowerCase();
  const status = $('#statusFilter').value;
  const visible = customers.filter(customer => {
    const matchesQuery = `${customer.name} ${customer.email} ${customer.account}`.toLowerCase().includes(query);
    return matchesQuery && (status === 'all' || customer.status === status);
  });

  rows.innerHTML = visible.length ? visible.map(customer => `
    <tr>
      <td><label class="checkbox-label"><input class="row-check" type="checkbox" aria-label="Select ${escapeHtml(customer.name)}"><span></span></label></td>
      <td><div class="customer-cell"><span class="customer-avatar" style="background:${safeColor(customer.color[0])};color:${safeColor(customer.color[1])}">${escapeHtml(customer.initials)}</span><span><span class="customer-name">${escapeHtml(customer.name)}</span><span class="customer-email">${escapeHtml(customer.email)}</span></span></div></td>
      <td class="account-number">${escapeHtml(customer.account)}</td>
      <td><span class="status-pill ${customer.status === 'Active' ? 'status-active' : 'status-review'}">${escapeHtml(customer.status)}</span></td>
      <td>${escapeHtml(customer.date)}</td>
      <td class="balance-cell">${money.format(customer.balance)}</td>
      <td class="action-cell"><button class="deposit-action" data-deposit="${customer.id}">Deposit</button></td>
    </tr>`).join('') : '<tr class="empty-row"><td colspan="7">No customers match your search.</td></tr>';

  const total = customers.reduce((sum, customer) => sum + Number(customer.balance), 0);
  $('#totalDeposits').textContent = money.format(total);
  $('#balanceOverview').textContent = money.format(total);
  $('#activeCustomers').textContent = customers.filter(customer => customer.status === 'Active').length.toLocaleString('en-US');
  $('#tableCount').textContent = `Showing ${visible.length} of ${customers.length} customers`;
  renderCustomerOptions();
  renderActivities();
}

function renderCustomerOptions(selectedId) {
  const select = $('#customerSelect');
  const currentId = selectedId ?? select.value;
  select.innerHTML = customers.map(customer => `<option value="${customer.id}">${escapeHtml(customer.name)}</option>`).join('');
  if (customers.some(customer => String(customer.id) === String(currentId))) select.value = currentId;
  updateSelectedAccount();
}

function renderActivities() {
  $('#activityList').innerHTML = activities.slice(0, 3).map(item => `<div class="activity-item"><span class="activity-icon ${item.type}">${item.icon}</span><span class="activity-copy"><strong>${escapeHtml(item.title)}</strong><small>${escapeHtml(item.detail)}</small></span>${item.amount ? `<span class="activity-amount ${item.amount.startsWith('+') ? 'positive' : ''}">${escapeHtml(item.amount)}</span>` : ''}</div>`).join('');
}

function openDeposit(customerId) {
  renderCustomerOptions(customerId);
  $('#depositAmount').value = '';
  $('#depositNote').value = '';
  if (typeof dialog.showModal === 'function') dialog.showModal();
  else dialog.setAttribute('open', '');
  window.setTimeout(() => $('#depositAmount').focus(), 50);
}

function updateSelectedAccount() {
  const customer = customers.find(item => String(item.id) === $('#customerSelect').value);
  const info = $('#selectedAccount');
  if (!customer) { info.classList.remove('visible'); info.textContent = ''; return; }
  info.textContent = `${customer.account} · Current balance ${money.format(customer.balance)}`;
  info.classList.add('visible');
}

function showToast(message) {
  toast.textContent = message;
  toast.classList.add('show');
  window.clearTimeout(toastTimeout);
  toastTimeout = window.setTimeout(() => toast.classList.remove('show'), 3200);
}

function escapeHtml(value) {
  return String(value).replace(/[&<>"']/g, character => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[character]);
}

function safeColor(value) { return /^#[0-9a-f]{3,8}$/i.test(value) ? value : '#edf2ff'; }

function closeDialog() {
  if (typeof dialog.close === 'function') dialog.close();
  else dialog.removeAttribute('open');
}

rows.addEventListener('click', event => {
  const button = event.target.closest('[data-deposit]');
  if (button) openDeposit(Number(button.dataset.deposit));
});
$('#depositTop').addEventListener('click', () => openDeposit(customers[0]?.id));
$('#closeDialog').addEventListener('click', closeDialog);
$('#cancelDialog').addEventListener('click', closeDialog);
$('#customerSelect').addEventListener('change', updateSelectedAccount);
$('#searchInput').addEventListener('input', render);
$('#statusFilter').addEventListener('change', render);
$('#filterButton').addEventListener('click', () => $('#statusFilter').focus());

$('#depositForm').addEventListener('submit', event => {
  event.preventDefault();
  const customer = customers.find(item => String(item.id) === $('#customerSelect').value);
  const amount = Number($('#depositAmount').value);
  if (!customer || !Number.isFinite(amount) || amount <= 0) return;
  customer.balance = Math.round((Number(customer.balance) + amount) * 100) / 100;
  const note = $('#depositNote').value.trim();
  activities.unshift({ icon: '↓', type: 'deposit', title: note || 'Deposit received', detail: `${customer.name} · Today, ${new Intl.DateTimeFormat('en-US', { hour: '2-digit', minute: '2-digit' }).format(new Date())}`, amount: `+${money.format(amount)}` });
  saveCustomers();
  render();
  closeDialog();
  showToast(`${money.format(amount)} deposited to ${customer.name}'s account.`);
});

$('#selectAll').addEventListener('change', event => {
  document.querySelectorAll('.row-check').forEach(checkbox => { checkbox.checked = event.target.checked; });
});
rows.addEventListener('change', event => {
  if (event.target.classList.contains('row-check') && !event.target.checked) $('#selectAll').checked = false;
});

$('#exportButton').addEventListener('click', () => {
  const header = ['Customer', 'Email', 'Account', 'Status', 'Date added', 'Balance'];
  const lines = [header, ...customers.map(customer => [customer.name, customer.email, customer.account, customer.status, customer.date, Number(customer.balance).toFixed(2)])]
    .map(line => line.map(value => `"${String(value).replace(/"/g, '""')}"`).join(','));
  const blob = new Blob([lines.join('\r\n')], { type: 'text/csv;charset=utf-8' });
  const url = URL.createObjectURL(blob);
  const link = document.createElement('a');
  link.href = url;
  link.download = 'northstar-customer-accounts.csv';
  link.click();
  URL.revokeObjectURL(url);
  showToast('Customer account report exported.');
});

const mobileMenu = $('#mobileMenu');
mobileMenu.addEventListener('click', () => {
  const isOpen = $('#sidebar').classList.toggle('open');
  mobileMenu.setAttribute('aria-expanded', String(isOpen));
});
document.querySelectorAll('.nav-item').forEach(link => link.addEventListener('click', () => {
  document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));
  link.classList.add('active');
  $('#sidebar').classList.remove('open');
  mobileMenu.setAttribute('aria-expanded', 'false');
}));

render();
