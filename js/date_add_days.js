Date.prototype.add_days = function (days) {
  this.setDate(this.getDate() + days);
  return this;
};