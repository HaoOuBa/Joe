(function () {
  var t = (function () {
      "use strict";
      function t() {
        return { LEFT: 0, RIGHT: 1, INTERSECTS: 2, AHEAD: 3, BEHIND: 4, SEPARATE: 5, UNDEFINED: 6 };
      }
      var e = Math.tan,
        s = Math.pow,
        i = Math.cos,
        h = Math.sin,
        a = Math.PI,
        n = Math.sqrt,
        l = Math.max,
        r = Math.min,
        o = Math.abs,
        c = Number.MAX_VALUE;
      class p {
        constructor(e, s, i, h) {
          (this.RoughSegmentRelationConst = t()),
            (this.px1 = e),
            (this.py1 = s),
            (this.px2 = i),
            (this.py2 = h),
            (this.xi = c),
            (this.yi = c),
            (this.a = h - s),
            (this.b = e - i),
            (this.c = i * s - e * h),
            (this._undefined = 0 == this.a && 0 == this.b && 0 == this.c);
        }
        isUndefined() {
          return this._undefined;
        }
        compare(t) {
          if (this.isUndefined() || t.isUndefined()) return this.RoughSegmentRelationConst.UNDEFINED;
          var e = c,
            s = c,
            i = 0,
            h = 0,
            a = this.a,
            n = this.b,
            p = this.c;
          return (
            1e-5 < o(n) && ((e = -a / n), (i = -p / n)),
            1e-5 < o(t.b) && ((s = -t.a / t.b), (h = -t.c / t.b)),
            e == c
              ? s == c
                ? -p / a == -t.c / t.a
                  ? this.py1 >= r(t.py1, t.py2) && this.py1 <= l(t.py1, t.py2)
                    ? ((this.xi = this.px1), (this.yi = this.py1), this.RoughSegmentRelationConst.INTERSECTS)
                    : this.py2 >= r(t.py1, t.py2) && this.py2 <= l(t.py1, t.py2)
                    ? ((this.xi = this.px2), (this.yi = this.py2), this.RoughSegmentRelationConst.INTERSECTS)
                    : this.RoughSegmentRelationConst.SEPARATE
                  : this.RoughSegmentRelationConst.SEPARATE
                : ((this.xi = this.px1),
                  (this.yi = s * this.xi + h),
                  -1e-5 > (this.py1 - this.yi) * (this.yi - this.py2) || -1e-5 > (t.py1 - this.yi) * (this.yi - t.py2)
                    ? this.RoughSegmentRelationConst.SEPARATE
                    : 1e-5 > o(t.a) && -1e-5 > (t.px1 - this.xi) * (this.xi - t.px2)
                    ? this.RoughSegmentRelationConst.SEPARATE
                    : this.RoughSegmentRelationConst.INTERSECTS)
              : s == c
              ? ((this.xi = t.px1),
                (this.yi = e * this.xi + i),
                -1e-5 > (t.py1 - this.yi) * (this.yi - t.py2) || -1e-5 > (this.py1 - this.yi) * (this.yi - this.py2)
                  ? this.RoughSegmentRelationConst.SEPARATE
                  : 1e-5 > o(a) && -1e-5 > (this.px1 - this.xi) * (this.xi - this.px2)
                  ? this.RoughSegmentRelationConst.SEPARATE
                  : this.RoughSegmentRelationConst.INTERSECTS)
              : e == s
              ? i == h
                ? this.px1 >= r(t.px1, t.px2) && this.px1 <= l(t.py1, t.py2)
                  ? ((this.xi = this.px1), (this.yi = this.py1), this.RoughSegmentRelationConst.INTERSECTS)
                  : this.px2 >= r(t.px1, t.px2) && this.px2 <= l(t.px1, t.px2)
                  ? ((this.xi = this.px2), (this.yi = this.py2), this.RoughSegmentRelationConst.INTERSECTS)
                  : this.RoughSegmentRelationConst.SEPARATE
                : this.RoughSegmentRelationConst.SEPARATE
              : ((this.xi = (h - i) / (e - s)),
                (this.yi = e * this.xi + i),
                -1e-5 > (this.px1 - this.xi) * (this.xi - this.px2) || -1e-5 > (t.px1 - this.xi) * (this.xi - t.px2) ? this.RoughSegmentRelationConst.SEPARATE : this.RoughSegmentRelationConst.INTERSECTS)
          );
        }
        getLength() {
          return this._getLength(this.px1, this.py1, this.px2, this.py2);
        }
        _getLength(t, e, s, i) {
          var h = s - t,
            a = i - e;
          return n(h * h + a * a);
        }
      }
      class f {
        constructor(t, e, s, i, h, a, n, l) {
          (this.top = t),
            (this.bottom = e),
            (this.left = s),
            (this.right = i),
            (this.gap = h),
            (this.sinAngle = a),
            (this.tanAngle = l),
            1e-4 > o(a)
              ? (this.pos = s + h)
              : 0.9999 < o(a)
              ? (this.pos = t + h)
              : ((this.deltaX = (e - t) * o(l)), (this.pos = s - o(this.deltaX)), (this.hGap = o(h / n)), (this.sLeft = new p(s, e, s, t)), (this.sRight = new p(i, e, i, t)));
        }
        getNextLine() {
          if (1e-4 > o(this.sinAngle)) {
            if (this.pos < this.right) {
              let t = [this.pos, this.top, this.pos, this.bottom];
              return (this.pos += this.gap), t;
            }
          } else if (0.9999 < o(this.sinAngle)) {
            if (this.pos < this.bottom) {
              let t = [this.left, this.pos, this.right, this.pos];
              return (this.pos += this.gap), t;
            }
          } else {
            let e = this.pos - this.deltaX / 2,
              s = this.pos + this.deltaX / 2,
              i = this.bottom,
              h = this.top;
            if (this.pos < this.right + this.deltaX) {
              for (; (e < this.left && s < this.left) || (e > this.right && s > this.right); )
                if (((this.pos += this.hGap), (e = this.pos - this.deltaX / 2), (s = this.pos + this.deltaX / 2), this.pos > this.right + this.deltaX)) return null;
              let a = new p(e, i, s, h);
              a.compare(this.sLeft) == t().INTERSECTS && ((e = a.xi), (i = a.yi)),
                a.compare(this.sRight) == t().INTERSECTS && ((s = a.xi), (h = a.yi)),
                0 < this.tanAngle && ((e = this.right - (e - this.left)), (s = this.right - (s - this.left)));
              let n = [e, i, s, h];
              return (this.pos += this.hGap), n;
            }
          }
          return null;
        }
      }
      class u {
        constructor(t, e) {
          (this.type = t), (this.text = e);
        }
        isType(t) {
          return this.type === t;
        }
      }
      class g {
        constructor(t) {
          (this.PARAMS = {
            A: ["rx", "ry", "x-axis-rotation", "large-arc-flag", "sweep-flag", "x", "y"],
            a: ["rx", "ry", "x-axis-rotation", "large-arc-flag", "sweep-flag", "x", "y"],
            C: ["x1", "y1", "x2", "y2", "x", "y"],
            c: ["x1", "y1", "x2", "y2", "x", "y"],
            H: ["x"],
            h: ["x"],
            L: ["x", "y"],
            l: ["x", "y"],
            M: ["x", "y"],
            m: ["x", "y"],
            Q: ["x1", "y1", "x", "y"],
            q: ["x1", "y1", "x", "y"],
            S: ["x2", "y2", "x", "y"],
            s: ["x2", "y2", "x", "y"],
            T: ["x", "y"],
            t: ["x", "y"],
            V: ["y"],
            v: ["y"],
            Z: [],
            z: [],
          }),
            (this.COMMAND = 0),
            (this.NUMBER = 1),
            (this.EOD = 2),
            (this.segments = []),
            (this.d = t || ""),
            this.parseData(t),
            this.processPoints();
        }
        loadFromSegments(t) {
          (this.segments = t), this.processPoints();
        }
        processPoints() {
          let t = null,
            e = [0, 0];
          for (let s, i = 0; i < this.segments.length; i++) {
            switch (((s = this.segments[i]), s.key)) {
              case "M":
              case "L":
              case "T":
                s.point = [s.data[0], s.data[1]];
                break;
              case "m":
              case "l":
              case "t":
                s.point = [s.data[0] + e[0], s.data[1] + e[1]];
                break;
              case "H":
                s.point = [s.data[0], e[1]];
                break;
              case "h":
                s.point = [s.data[0] + e[0], e[1]];
                break;
              case "V":
                s.point = [e[0], s.data[0]];
                break;
              case "v":
                s.point = [e[0], s.data[0] + e[1]];
                break;
              case "z":
              case "Z":
                t && (s.point = [t[0], t[1]]);
                break;
              case "C":
                s.point = [s.data[4], s.data[5]];
                break;
              case "c":
                s.point = [s.data[4] + e[0], s.data[5] + e[1]];
                break;
              case "S":
                s.point = [s.data[2], s.data[3]];
                break;
              case "s":
                s.point = [s.data[2] + e[0], s.data[3] + e[1]];
                break;
              case "Q":
                s.point = [s.data[2], s.data[3]];
                break;
              case "q":
                s.point = [s.data[2] + e[0], s.data[3] + e[1]];
                break;
              case "A":
                s.point = [s.data[5], s.data[6]];
                break;
              case "a":
                s.point = [s.data[5] + e[0], s.data[6] + e[1]];
            }
            ("m" === s.key || "M" === s.key) && (t = null), s.point && ((e = s.point), !t && (t = s.point)), ("z" === s.key || "Z" === s.key) && (t = null);
          }
        }
        get closed() {
          if (void 0 === this._closed) {
            this._closed = !1;
            for (let t of this.segments) "z" === t.key.toLowerCase() && (this._closed = !0);
          }
          return this._closed;
        }
        parseData(t) {
          var e = this.tokenize(t),
            s = 0,
            i = e[s],
            h = "BOD";
          for (this.segments = []; !i.isType(this.EOD); ) {
            var a,
              n = [];
            if ("BOD" != h) i.isType(this.NUMBER) ? (a = this.PARAMS[h].length) : (s++, (a = this.PARAMS[i.text].length), (h = i.text));
            else {
              if ("M" != i.text && "m" != i.text) return this.parseData("M0,0" + t);
              s++, (a = this.PARAMS[i.text].length), (h = i.text);
            }
            if (s + a < e.length) {
              for (var l, r = s; r < s + a; r++) {
                if (((l = e[r]), !l.isType(this.NUMBER))) return void console.error("Parameter type is not a number: " + h + "," + l.text);
                n[n.length] = l.text;
              }
              var o;
              if (!this.PARAMS[h]) return void console.error("Unsupported segment type: " + h);
              (o = { key: h, data: n }), this.segments.push(o), (s += a), (i = e[s]), "M" == h && (h = "L"), "m" == h && (h = "l");
            } else console.error("Path data ended before all parameters were found");
          }
        }
        tokenize(t) {
          for (var e = []; "" != t; )
            if (t.match(/^([ \t\r\n,]+)/)) t = t.substr(RegExp.$1.length);
            else if (t.match(/^([aAcChHlLmMqQsStTvVzZ])/)) (e[e.length] = new u(this.COMMAND, RegExp.$1)), (t = t.substr(RegExp.$1.length));
            else {
              if (!t.match(/^(([-+]?[0-9]+(\.[0-9]*)?|[-+]?\.[0-9]+)([eE][-+]?[0-9]+)?)/)) return console.error("Unrecognized segment command: " + t), null;
              (e[e.length] = new u(this.NUMBER, parseFloat(RegExp.$1))), (t = t.substr(RegExp.$1.length));
            }
          return (e[e.length] = new u(this.EOD, null)), e;
        }
      }
      class d {
        constructor(t) {
          (this.d = t), (this.parsed = new g(t)), (this._position = [0, 0]), (this.bezierReflectionPoint = null), (this.quadReflectionPoint = null), (this._first = null);
        }
        get segments() {
          return this.parsed.segments;
        }
        get closed() {
          return this.parsed.closed;
        }
        get linearPoints() {
          if (!this._linearPoints) {
            const t = [];
            let e = [];
            for (let s of this.parsed.segments) {
              let i = s.key.toLowerCase();
              (("m" === i || "z" === i) && (e.length && (t.push(e), (e = [])), "z" === i)) || (s.point && e.push(s.point));
            }
            e.length && (t.push(e), (e = [])), (this._linearPoints = t);
          }
          return this._linearPoints;
        }
        get first() {
          return this._first;
        }
        set first(t) {
          this._first = t;
        }
        setPosition(t, e) {
          (this._position = [t, e]), this._first || (this._first = [t, e]);
        }
        get position() {
          return this._position;
        }
        get x() {
          return this._position[0];
        }
        get y() {
          return this._position[1];
        }
      }
      class _ {
        constructor(t, e, s, l, r, c) {
          const p = a / 180;
          if (((this._segIndex = 0), (this._numSegs = 0), t[0] == e[0] && t[1] == e[1])) return;
          (this._rx = o(s[0])), (this._ry = o(s[1])), (this._sinPhi = h(l * p)), (this._cosPhi = i(l * p));
          var f,
            u = (this._cosPhi * (t[0] - e[0])) / 2 + (this._sinPhi * (t[1] - e[1])) / 2,
            g = (-this._sinPhi * (t[0] - e[0])) / 2 + (this._cosPhi * (t[1] - e[1])) / 2,
            d = this._rx * this._rx * this._ry * this._ry - this._rx * this._rx * g * g - this._ry * this._ry * u * u;
          if (0 > d) {
            let t = n(1 - d / (this._rx * this._rx * this._ry * this._ry));
            (this._rx = t), (this._ry = t), (f = 0);
          } else f = (r == c ? -1 : 1) * n(d / (this._rx * this._rx * g * g + this._ry * this._ry * u * u));
          let _ = (f * this._rx * g) / this._ry,
            y = (-f * this._ry * u) / this._rx;
          (this._C = [0, 0]),
            (this._C[0] = this._cosPhi * _ - this._sinPhi * y + (t[0] + e[0]) / 2),
            (this._C[1] = this._sinPhi * _ + this._cosPhi * y + (t[1] + e[1]) / 2),
            (this._theta = this.calculateVectorAngle(1, 0, (u - _) / this._rx, (g - y) / this._ry));
          let x = this.calculateVectorAngle((u - _) / this._rx, (g - y) / this._ry, (-u - _) / this._rx, (-g - y) / this._ry);
          !c && 0 < x ? (x -= 2 * a) : c && 0 > x && (x += 2 * a),
            (this._numSegs = Math.ceil(o(x / (a / 2)))),
            (this._delta = x / this._numSegs),
            (this._T = ((8 / 3) * h(this._delta / 4) * h(this._delta / 4)) / h(this._delta / 2)),
            (this._from = t);
        }
        getNextSegment() {
          var t, e, s;
          if (this._segIndex == this._numSegs) return null;
          let a = i(this._theta),
            n = h(this._theta),
            l = this._theta + this._delta,
            r = i(l),
            o = h(l);
          return (
            (s = [this._cosPhi * this._rx * r - this._sinPhi * this._ry * o + this._C[0], this._sinPhi * this._rx * r + this._cosPhi * this._ry * o + this._C[1]]),
            (t = [this._from[0] + this._T * (-this._cosPhi * this._rx * n - this._sinPhi * this._ry * a), this._from[1] + this._T * (-this._sinPhi * this._rx * n + this._cosPhi * this._ry * a)]),
            (e = [s[0] + this._T * (this._cosPhi * this._rx * o + this._sinPhi * this._ry * r), s[1] + this._T * (this._sinPhi * this._rx * o - this._cosPhi * this._ry * r)]),
            (this._theta = l),
            (this._from = [s[0], s[1]]),
            this._segIndex++,
            { cp1: t, cp2: e, to: s }
          );
        }
        calculateVectorAngle(t, e, s, i) {
          var h = Math.atan2;
          let n = h(e, t),
            l = h(i, s);
          return l >= n ? l - n : 2 * a - (n - l);
        }
      }
      class y {
        constructor(t, e) {
          (this.sets = t), (this.closed = e);
        }
        fit(t) {
          let e = [];
          for (const s of this.sets) {
            let i = s.length,
              h = Math.floor(t * i);
            if (5 > h) {
              if (5 >= i) continue;
              h = 5;
            }
            e.push(this.reduce(s, h));
          }
          let s = "";
          for (const t of e) {
            for (let e, i = 0; i < t.length; i++) (e = t[i]), (s += 0 === i ? "M" + e[0] + "," + e[1] : "L" + e[0] + "," + e[1]);
            this.closed && (s += "z ");
          }
          return s;
        }
        distance(t, e) {
          return n(s(t[0] - e[0], 2) + s(t[1] - e[1], 2));
        }
        reduce(t, e) {
          if (t.length <= e) return t;
          let s = t.slice(0);
          for (; s.length > e; ) {
            let t = -1,
              e = -1;
            for (let i = 1; i < s.length - 1; i++) {
              let h = this.distance(s[i - 1], s[i]),
                a = this.distance(s[i], s[i + 1]),
                l = this.distance(s[i - 1], s[i + 1]),
                r = (h + a + l) / 2,
                o = n(r * (r - h) * (r - a) * (r - l));
              (0 > t || o < t) && ((t = o), (e = i));
            }
            if (!(0 < e)) break;
            s.splice(e, 1);
          }
          return s;
        }
      }
      class x {
        line(t, e, s, i, h) {
          let a = this._doubleLine(t, e, s, i, h);
          return { type: "path", ops: a };
        }
        linearPath(t, e, s) {
          const i = (t || []).length;
          if (2 < i) {
            let h = [];
            for (let e = 0; e < i - 1; e++) h = h.concat(this._doubleLine(t[e][0], t[e][1], t[e + 1][0], t[e + 1][1], s));
            return e && (h = h.concat(this._doubleLine(t[i - 1][0], t[i - 1][1], t[0][0], t[0][1], s))), { type: "path", ops: h };
          }
          return 2 === i ? this.line(t[0][0], t[0][1], t[1][0], t[1][1], s) : void 0;
        }
        polygon(t, e) {
          return this.linearPath(t, !0, e);
        }
        rectangle(t, e, s, i, h) {
          return this.polygon(
            [
              [t, e],
              [t + s, e],
              [t + s, e + i],
              [t, e + i],
            ],
            h
          );
        }
        curve(t, e) {
          let s = this._curveWithOffset(t, 1 * (1 + 0.2 * e.roughness), e),
            i = this._curveWithOffset(t, 1.5 * (1 + 0.22 * e.roughness), e);
          return { type: "path", ops: s.concat(i) };
        }
        ellipse(t, e, s, i, h) {
          const n = (2 * a) / h.curveStepCount;
          let l = o(s / 2),
            r = o(i / 2);
          (l += this._getOffset(0.05 * -l, 0.05 * l, h)), (r += this._getOffset(0.05 * -r, 0.05 * r, h));
          let c = this._ellipse(n, t, e, l, r, 1, n * this._getOffset(0.1, this._getOffset(0.4, 1, h), h), h),
            p = this._ellipse(n, t, e, l, r, 1.5, 0, h);
          return { type: "path", ops: c.concat(p) };
        }
        arc(t, e, s, n, l, c, p, f, u) {
          let g = t,
            d = e,
            _ = o(s / 2),
            y = o(n / 2);
          (_ += this._getOffset(0.01 * -_, 0.01 * _, u)), (y += this._getOffset(0.01 * -y, 0.01 * y, u));
          let x = l,
            b = c;
          for (; 0 > x; ) (x += 2 * a), (b += 2 * a);
          b - x > 2 * a && ((x = 0), (b = 2 * a));
          let m = (2 * a) / u.curveStepCount,
            w = r(m / 2, (b - x) / 2),
            O = this._arc(w, g, d, _, y, x, b, 1, u),
            S = this._arc(w, g, d, _, y, x, b, 1.5, u),
            v = O.concat(S);
          return (
            p &&
              (f
                ? ((v = v.concat(this._doubleLine(g, d, g + _ * i(x), d + y * h(x), u))), (v = v.concat(this._doubleLine(g, d, g + _ * i(b), d + y * h(b), u))))
                : (v.push({ op: "lineTo", data: [g, d] }), v.push({ op: "lineTo", data: [g + _ * i(x), d + y * h(x)] }))),
            { type: "path", ops: v }
          );
        }
        hachureFillArc(t, e, s, n, l, r, c) {
          let p = t,
            f = e,
            u = o(s / 2),
            g = o(n / 2);
          (u += this._getOffset(0.01 * -u, 0.01 * u, c)), (g += this._getOffset(0.01 * -g, 0.01 * g, c));
          let d = l,
            _ = r;
          for (; 0 > d; ) (d += 2 * a), (_ += 2 * a);
          _ - d > 2 * a && ((d = 0), (_ = 2 * a));
          let y = (_ - d) / c.curveStepCount,
            x = [],
            b = [];
          for (let t = d; t <= _; t += y) x.push(p + u * i(t)), b.push(f + g * h(t));
          return x.push(p + u * i(_)), b.push(f + g * h(_)), x.push(p), b.push(f), this.hachureFillShape(x, b, c);
        }
        solidFillShape(t, e, s) {
          let i = [];
          if (t && e && t.length && e.length && t.length === e.length) {
            let a = s.maxRandomnessOffset || 0;
            const n = t.length;
            if (2 < n) {
              i.push({ op: "move", data: [t[0] + this._getOffset(-a, a, s), e[0] + this._getOffset(-a, a, s)] });
              for (var h = 1; h < n; h++) i.push({ op: "lineTo", data: [t[h] + this._getOffset(-a, a, s), e[h] + this._getOffset(-a, a, s)] });
            }
          }
          return { type: "fillPath", ops: i };
        }
        hachureFillShape(t, s, n) {
          let o = [];
          if (t && s && t.length && s.length) {
            let c = t[0],
              p = t[0],
              u = s[0],
              g = s[0];
            for (let e = 1; e < t.length; e++) (c = r(c, t[e])), (p = l(p, t[e])), (u = r(u, s[e])), (g = l(g, s[e]));
            const d = n.hachureAngle;
            let _ = n.hachureGap;
            0 > _ && (_ = 4 * n.strokeWidth), (_ = l(_, 0.1));
            const y = (d % 180) * (a / 180),
              x = i(y),
              b = h(y),
              m = e(y),
              w = new f(u - 1, g + 1, c - 1, p + 1, _, b, x, m);
            for (let e; null != (e = w.getNextLine()); ) {
              let i = this._getIntersectingLines(e, t, s);
              for (let t = 0; t < i.length; t++)
                if (t < i.length - 1) {
                  let e = i[t],
                    s = i[t + 1];
                  o = o.concat(this._doubleLine(e[0], e[1], s[0], s[1], n));
                }
            }
          }
          return { type: "fillSketch", ops: o };
        }
        hachureFillEllipse(t, s, i, h, l) {
          let r = [],
            c = o(i / 2),
            p = o(h / 2);
          (c += this._getOffset(0.05 * -c, 0.05 * c, l)), (p += this._getOffset(0.05 * -p, 0.05 * p, l));
          let f = l.hachureAngle,
            u = l.hachureGap;
          0 >= u && (u = 4 * l.strokeWidth);
          let g = l.fillWeight;
          0 > g && (g = l.strokeWidth / 2);
          let d = e((f % 180) * (a / 180)),
            _ = p / c,
            y = n(_ * d * _ * d + 1),
            x = (_ * d) / y,
            b = 1 / y,
            m = u / ((c * p) / n(p * b * (p * b) + c * x * (c * x)) / c),
            w = n(c * c - (t - c + m) * (t - c + m));
          for (var O = t - c + m; O < t + c; O += m) {
            w = n(c * c - (t - O) * (t - O));
            let e = this._affine(O, s - w, t, s, x, b, _),
              i = this._affine(O, s + w, t, s, x, b, _);
            r = r.concat(this._doubleLine(e[0], e[1], i[0], i[1], l));
          }
          return { type: "fillSketch", ops: r };
        }
        svgPath(t, e) {
          t = (t || "").replace(/\n/g, " ").replace(/(-)/g, " -").replace(/(-\s)/g, "-").replace("/(ss)/g", " ");
          let s = new d(t);
          if (e.simplification) {
            let t = new y(s.linearPoints, s.closed),
              i = t.fit(e.simplification);
            s = new d(i);
          }
          let i = [],
            h = s.segments || [];
          for (let t = 0; t < h.length; t++) {
            let a = h[t],
              n = 0 < t ? h[t - 1] : null,
              l = this._processSegment(s, a, n, e);
            l && l.length && (i = i.concat(l));
          }
          return { type: "path", ops: i };
        }
        _bezierTo(t, e, s, i, h, a, n, l) {
          let r = [],
            o = [l.maxRandomnessOffset || 1, (l.maxRandomnessOffset || 1) + 0.5],
            c = null;
          for (let p = 0; 2 > p; p++)
            0 === p ? r.push({ op: "move", data: [n.x, n.y] }) : r.push({ op: "move", data: [n.x + this._getOffset(-o[0], o[0], l), n.y + this._getOffset(-o[0], o[0], l)] }),
              (c = [h + this._getOffset(-o[p], o[p], l), a + this._getOffset(-o[p], o[p], l)]),
              r.push({ op: "bcurveTo", data: [t + this._getOffset(-o[p], o[p], l), e + this._getOffset(-o[p], o[p], l), s + this._getOffset(-o[p], o[p], l), i + this._getOffset(-o[p], o[p], l), c[0], c[1]] });
          return n.setPosition(c[0], c[1]), r;
        }
        _processSegment(t, e, s, i) {
          let h = [];
          switch (e.key) {
            case "M":
            case "m": {
              let s = "m" === e.key;
              if (2 <= e.data.length) {
                let a = +e.data[0],
                  n = +e.data[1];
                s && ((a += t.x), (n += t.y));
                let l = 1 * (i.maxRandomnessOffset || 0);
                (a += this._getOffset(-l, l, i)), (n += this._getOffset(-l, l, i)), t.setPosition(a, n), h.push({ op: "move", data: [a, n] });
              }
              break;
            }
            case "L":
            case "l": {
              let s = "l" === e.key;
              if (2 <= e.data.length) {
                let a = +e.data[0],
                  n = +e.data[1];
                s && ((a += t.x), (n += t.y)), (h = h.concat(this._doubleLine(t.x, t.y, a, n, i))), t.setPosition(a, n);
              }
              break;
            }
            case "H":
            case "h": {
              const s = "h" === e.key;
              if (e.data.length) {
                let a = +e.data[0];
                s && (a += t.x), (h = h.concat(this._doubleLine(t.x, t.y, a, t.y, i))), t.setPosition(a, t.y);
              }
              break;
            }
            case "V":
            case "v": {
              const s = "v" === e.key;
              if (e.data.length) {
                let a = +e.data[0];
                s && (a += t.y), (h = h.concat(this._doubleLine(t.x, t.y, t.x, a, i))), t.setPosition(t.x, a);
              }
              break;
            }
            case "Z":
            case "z":
              t.first && ((h = h.concat(this._doubleLine(t.x, t.y, t.first[0], t.first[1], i))), t.setPosition(t.first[0], t.first[1]), (t.first = null));
              break;
            case "C":
            case "c": {
              const s = "c" === e.key;
              if (6 <= e.data.length) {
                let a = +e.data[0],
                  n = +e.data[1],
                  l = +e.data[2],
                  r = +e.data[3],
                  o = +e.data[4],
                  c = +e.data[5];
                s && ((a += t.x), (l += t.x), (o += t.x), (n += t.y), (r += t.y), (c += t.y));
                let p = this._bezierTo(a, n, l, r, o, c, t, i);
                (h = h.concat(p)), (t.bezierReflectionPoint = [o + (o - l), c + (c - r)]);
              }
              break;
            }
            case "S":
            case "s": {
              const n = "s" === e.key;
              if (4 <= e.data.length) {
                let l = +e.data[0],
                  r = +e.data[1],
                  o = +e.data[2],
                  c = +e.data[3];
                n && ((l += t.x), (o += t.x), (r += t.y), (c += t.y));
                let p = l,
                  f = r,
                  u = s ? s.key : "";
                var a = null;
                ("c" == u || "C" == u || "s" == u || "S" == u) && (a = t.bezierReflectionPoint), a && ((p = a[0]), (f = a[1]));
                let g = this._bezierTo(p, f, l, r, o, c, t, i);
                (h = h.concat(g)), (t.bezierReflectionPoint = [o + (o - l), c + (c - r)]);
              }
              break;
            }
            case "Q":
            case "q": {
              const s = "q" === e.key;
              if (4 <= e.data.length) {
                let a = +e.data[0],
                  n = +e.data[1],
                  l = +e.data[2],
                  r = +e.data[3];
                s && ((a += t.x), (l += t.x), (n += t.y), (r += t.y));
                let o = 1 * (1 + 0.2 * i.roughness),
                  c = 1.5 * (1 + 0.22 * i.roughness);
                h.push({ op: "move", data: [t.x + this._getOffset(-o, o, i), t.y + this._getOffset(-o, o, i)] });
                let p = [l + this._getOffset(-o, o, i), r + this._getOffset(-o, o, i)];
                h.push({ op: "qcurveTo", data: [a + this._getOffset(-o, o, i), n + this._getOffset(-o, o, i), p[0], p[1]] }),
                  h.push({ op: "move", data: [t.x + this._getOffset(-c, c, i), t.y + this._getOffset(-c, c, i)] }),
                  (p = [l + this._getOffset(-c, c, i), r + this._getOffset(-c, c, i)]),
                  h.push({ op: "qcurveTo", data: [a + this._getOffset(-c, c, i), n + this._getOffset(-c, c, i), p[0], p[1]] }),
                  t.setPosition(p[0], p[1]),
                  (t.quadReflectionPoint = [l + (l - a), r + (r - n)]);
              }
              break;
            }
            case "T":
            case "t": {
              const n = "t" === e.key;
              if (2 <= e.data.length) {
                let l = +e.data[0],
                  r = +e.data[1];
                n && ((l += t.x), (r += t.y));
                let o = l,
                  c = r,
                  p = s ? s.key : "";
                (a = null), ("q" == p || "Q" == p || "t" == p || "T" == p) && (a = t.quadReflectionPoint), a && ((o = a[0]), (c = a[1]));
                let f = 1 * (1 + 0.2 * i.roughness),
                  u = 1.5 * (1 + 0.22 * i.roughness);
                h.push({ op: "move", data: [t.x + this._getOffset(-f, f, i), t.y + this._getOffset(-f, f, i)] });
                let g = [l + this._getOffset(-f, f, i), r + this._getOffset(-f, f, i)];
                h.push({ op: "qcurveTo", data: [o + this._getOffset(-f, f, i), c + this._getOffset(-f, f, i), g[0], g[1]] }),
                  h.push({ op: "move", data: [t.x + this._getOffset(-u, u, i), t.y + this._getOffset(-u, u, i)] }),
                  (g = [l + this._getOffset(-u, u, i), r + this._getOffset(-u, u, i)]),
                  h.push({ op: "qcurveTo", data: [o + this._getOffset(-u, u, i), c + this._getOffset(-u, u, i), g[0], g[1]] }),
                  t.setPosition(g[0], g[1]),
                  (t.quadReflectionPoint = [l + (l - o), r + (r - c)]);
              }
              break;
            }
            case "A":
            case "a": {
              const s = "a" === e.key;
              if (7 <= e.data.length) {
                let a = +e.data[0],
                  n = +e.data[1],
                  l = +e.data[2],
                  r = +e.data[3],
                  o = +e.data[4],
                  c = +e.data[5],
                  p = +e.data[6];
                if ((s && ((c += t.x), (p += t.y)), c == t.x && p == t.y)) break;
                if (0 == a || 0 == n) (h = h.concat(this._doubleLine(t.x, t.y, c, p, i))), t.setPosition(c, p);
                else {
                  i.maxRandomnessOffset;
                  for (let e = 0; 1 > e; e++) {
                    let e = new _([t.x, t.y], [c, p], [a, n], l, !!r, !!o),
                      s = e.getNextSegment();
                    for (; s; ) {
                      let a = this._bezierTo(s.cp1[0], s.cp1[1], s.cp2[0], s.cp2[1], s.to[0], s.to[1], t, i);
                      (h = h.concat(a)), (s = e.getNextSegment());
                    }
                  }
                }
              }
              break;
            }
          }
          return h;
        }
        _getOffset(t, e, s) {
          return s.roughness * (Math.random() * (e - t) + t);
        }
        _affine(t, e, s, i, h, a, n) {
          return [-s * a - i * h + s + a * t + h * e, n * (s * h - i * a) + i + -n * h * t + n * a * e];
        }
        _doubleLine(t, e, s, i, h) {
          const a = this._line(t, e, s, i, h, !0, !1),
            n = this._line(t, e, s, i, h, !0, !0);
          return a.concat(n);
        }
        _line(t, e, i, h, a, l, r) {
          const o = s(t - i, 2) + s(e - h, 2);
          let c = a.maxRandomnessOffset || 0;
          c * c * 100 > o && (c = n(o) / 10);
          const p = c / 2,
            f = 0.2 + 0.2 * Math.random();
          let u = (a.bowing * a.maxRandomnessOffset * (h - e)) / 200,
            g = (a.bowing * a.maxRandomnessOffset * (t - i)) / 200;
          (u = this._getOffset(-u, u, a)), (g = this._getOffset(-g, g, a));
          let d = [];
          return (
            l && (r ? d.push({ op: "move", data: [t + this._getOffset(-p, p, a), e + this._getOffset(-p, p, a)] }) : d.push({ op: "move", data: [t + this._getOffset(-c, c, a), e + this._getOffset(-c, c, a)] })),
            r
              ? d.push({
                  op: "bcurveTo",
                  data: [
                    u + t + (i - t) * f + this._getOffset(-p, p, a),
                    g + e + (h - e) * f + this._getOffset(-p, p, a),
                    u + t + 2 * (i - t) * f + this._getOffset(-p, p, a),
                    g + e + 2 * (h - e) * f + this._getOffset(-p, p, a),
                    i + this._getOffset(-p, p, a),
                    h + this._getOffset(-p, p, a),
                  ],
                })
              : d.push({
                  op: "bcurveTo",
                  data: [
                    u + t + (i - t) * f + this._getOffset(-c, c, a),
                    g + e + (h - e) * f + this._getOffset(-c, c, a),
                    u + t + 2 * (i - t) * f + this._getOffset(-c, c, a),
                    g + e + 2 * (h - e) * f + this._getOffset(-c, c, a),
                    i + this._getOffset(-c, c, a),
                    h + this._getOffset(-c, c, a),
                  ],
                }),
            d
          );
        }
        _curve(t, e, s) {
          const i = t.length;
          let h = [];
          if (3 < i) {
            const a = [],
              n = 1 - s.curveTightness;
            h.push({ op: "move", data: [t[1][0], t[1][1]] });
            for (let e = 1; e + 2 < i; e++) {
              const s = t[e];
              (a[0] = [s[0], s[1]]),
                (a[1] = [s[0] + (n * t[e + 1][0] - n * t[e - 1][0]) / 6, s[1] + (n * t[e + 1][1] - n * t[e - 1][1]) / 6]),
                (a[2] = [t[e + 1][0] + (n * t[e][0] - n * t[e + 2][0]) / 6, t[e + 1][1] + (n * t[e][1] - n * t[e + 2][1]) / 6]),
                (a[3] = [t[e + 1][0], t[e + 1][1]]),
                h.push({ op: "bcurveTo", data: [a[1][0], a[1][1], a[2][0], a[2][1], a[3][0], a[3][1]] });
            }
            if (e && 2 === e.length) {
              let t = s.maxRandomnessOffset;
              h.push({ ops: "lineTo", data: [e[0] + this._getOffset(-t, t, s), e[1] + +this._getOffset(-t, t, s)] });
            }
          } else
            3 === i
              ? (h.push({ op: "move", data: [t[1][0], t[1][1]] }), h.push({ op: "bcurveTo", data: [t[1][0], t[1][1], t[2][0], t[2][1], t[2][0], t[2][1]] }))
              : 2 === i && (h = h.concat(this._doubleLine(t[0][0], t[0][1], t[1][0], t[1][1], s)));
          return h;
        }
        _ellipse(t, e, s, n, l, r, o, c) {
          const p = this._getOffset(-0.5, 0.5, c) - a / 2,
            f = [];
          f.push([this._getOffset(-r, r, c) + e + 0.9 * n * i(p - t), this._getOffset(-r, r, c) + s + 0.9 * l * h(p - t)]);
          for (let o = p; o < 2 * a + p - 0.01; o += t) f.push([this._getOffset(-r, r, c) + e + n * i(o), this._getOffset(-r, r, c) + s + l * h(o)]);
          return (
            f.push([this._getOffset(-r, r, c) + e + n * i(p + 2 * a + 0.5 * o), this._getOffset(-r, r, c) + s + l * h(p + 2 * a + 0.5 * o)]),
            f.push([this._getOffset(-r, r, c) + e + 0.98 * n * i(p + o), this._getOffset(-r, r, c) + s + 0.98 * l * h(p + o)]),
            f.push([this._getOffset(-r, r, c) + e + 0.9 * n * i(p + 0.5 * o), this._getOffset(-r, r, c) + s + 0.9 * l * h(p + 0.5 * o)]),
            this._curve(f, null, c)
          );
        }
        _curveWithOffset(t, e, s) {
          const i = [
            [t[0][0] + this._getOffset(-e, e, s), t[0][1] + this._getOffset(-e, e, s)],
            [t[0][0] + this._getOffset(-e, e, s), t[0][1] + this._getOffset(-e, e, s)],
          ];
          for (let h = 1; h < t.length; h++)
            i.push([t[h][0] + this._getOffset(-e, e, s), t[h][1] + this._getOffset(-e, e, s)]), h === t.length - 1 && i.push([t[h][0] + this._getOffset(-e, e, s), t[h][1] + this._getOffset(-e, e, s)]);
          return this._curve(i, null, s);
        }
        _arc(t, e, s, a, n, l, r, o, c) {
          const p = l + this._getOffset(-0.1, 0.1, c),
            f = [];
          f.push([this._getOffset(-o, o, c) + e + 0.9 * a * i(p - t), this._getOffset(-o, o, c) + s + 0.9 * n * h(p - t)]);
          for (let l = p; l <= r; l += t) f.push([this._getOffset(-o, o, c) + e + a * i(l), this._getOffset(-o, o, c) + s + n * h(l)]);
          return f.push([e + a * i(r), s + n * h(r)]), f.push([e + a * i(r), s + n * h(r)]), this._curve(f, null, c);
        }
        _getIntersectingLines(e, s, i) {
          let h = [];
          for (var a = new p(e[0], e[1], e[2], e[3]), n = 0; n < s.length; n++) {
            let e = new p(s[n], i[n], s[(n + 1) % s.length], i[(n + 1) % s.length]);
            a.compare(e) == t().INTERSECTS && h.push([a.xi, a.yi]);
          }
          return h;
        }
      }
      self._roughScript = self.document && self.document.currentScript && self.document.currentScript.src;
      class b {
        constructor(t, e) {
          (this.config = t || {}),
            (this.canvas = e),
            (this.defaultOptions = {
              maxRandomnessOffset: 2,
              roughness: 1,
              bowing: 1,
              stroke: "#000",
              strokeWidth: 1,
              curveTightness: 0,
              curveStepCount: 9,
              fill: null,
              fillStyle: "hachure",
              fillWeight: -1,
              hachureAngle: -41,
              hachureGap: -1,
            }),
            this.config.options && (this.defaultOptions = this._options(this.config.options));
        }
        _options(t) {
          return t ? Object.assign({}, this.defaultOptions, t) : this.defaultOptions;
        }
        _drawable(t, e, s) {
          return { shape: t, sets: e || [], options: s || this.defaultOptions };
        }
        get lib() {
          if (!this._renderer)
            if (self && self.workly && this.config.async && !this.config.noWorker) {
              Function.prototype.toString;
              const t = this.config.worklyURL || "https://fastly.jsdelivr.net/gh/pshihn/workly/dist/workly.min.js",
                e = this.config.roughURL || self._roughScript;
              if (e && t) {
                let s = `importScripts('${t}','${e}');\nworkly.expose(self.rough.createRenderer());`,
                  i = URL.createObjectURL(new Blob([s]));
                this._renderer = workly.proxy(i);
              } else this._renderer = new x();
            } else this._renderer = new x();
          return this._renderer;
        }
        line(t, e, s, i, h) {
          const a = this._options(h);
          return this._drawable("line", [this.lib.line(t, e, s, i, a)], a);
        }
        rectangle(t, e, s, i, h) {
          const a = this._options(h),
            n = [];
          if (a.fill) {
            const h = [t, t + s, t + s, t],
              l = [e, e, e + i, e + i];
            "solid" === a.fillStyle ? n.push(this.lib.solidFillShape(h, l, a)) : n.push(this.lib.hachureFillShape(h, l, a));
          }
          return n.push(this.lib.rectangle(t, e, s, i, a)), this._drawable("rectangle", n, a);
        }
        ellipse(t, e, s, i, h) {
          const a = this._options(h),
            n = [];
          if (a.fill)
            if ("solid" === a.fillStyle) {
              const h = this.lib.ellipse(t, e, s, i, a);
              (h.type = "fillPath"), n.push(h);
            } else n.push(this.lib.hachureFillEllipse(t, e, s, i, a));
          return n.push(this.lib.ellipse(t, e, s, i, a)), this._drawable("ellipse", n, a);
        }
        circle(t, e, s, i) {
          let h = this.ellipse(t, e, s, s, i);
          return (h.shape = "circle"), h;
        }
        linearPath(t, e) {
          const s = this._options(e);
          return this._drawable("linearPath", [this.lib.linearPath(t, !1, s)], s);
        }
        polygon(t, e) {
          const s = this._options(e),
            i = [];
          if (s.fill) {
            let e = [],
              h = [];
            for (let s of t) e.push(s[0]), h.push(s[1]);
            "solid" === s.fillStyle ? i.push(this.lib.solidFillShape(e, h, s)) : i.push(this.lib.hachureFillShape(e, h, s));
          }
          return i.push(this.lib.linearPath(t, !0, s)), this._drawable("polygon", i, s);
        }
        arc(t, e, s, i, h, a, n, l) {
          const r = this._options(l),
            o = [];
          if (n && r.fill)
            if ("solid" === r.fillStyle) {
              let n = this.lib.arc(t, e, s, i, h, a, !0, !1, r);
              (n.type = "fillPath"), o.push(n);
            } else o.push(this.lib.hachureFillArc(t, e, s, i, h, a, r));
          return o.push(this.lib.arc(t, e, s, i, h, a, n, !0, r)), this._drawable("arc", o, r);
        }
        curve(t, e) {
          const s = this._options(e);
          return this._drawable("curve", [this.lib.curve(t, s)], s);
        }
        path(t, e) {
          const s = this._options(e),
            i = [];
          if (!t) return this._drawable("path", i, s);
          if (s.fill)
            if ("solid" === s.fillStyle) i.push({ type: "path2Dfill", path: t });
            else {
              const e = this._computePathSize(t);
              let h = [0, e[0], e[0], 0],
                a = [0, 0, e[1], e[1]],
                n = this.lib.hachureFillShape(h, a, s);
              (n.type = "path2Dpattern"), (n.size = e), (n.path = t), i.push(n);
            }
          return i.push(this.lib.svgPath(t, s)), this._drawable("path", i, s);
        }
        _computePathSize(t) {
          let e = [0, 0];
          if (self.document)
            try {
              const s = "http://www.w3.org/2000/svg";
              let i = self.document.createElementNS(s, "svg");
              i.setAttribute("width", "0"), i.setAttribute("height", "0");
              let h = self.document.createElementNS(s, "path");
              h.setAttribute("d", t), i.appendChild(h), self.document.body.appendChild(i);
              let a = h.getBBox();
              a && ((e[0] = a.width || 0), (e[1] = a.height || 0)), self.document.body.removeChild(i);
            } catch (t) {}
          return e[0] * e[1] || (e = [this.canvas.width || 100, this.canvas.height || 100]), (e[0] = r(4 * e[0], this.canvas.width)), (e[1] = r(4 * e[1], this.canvas.height)), e;
        }
      }
      class m extends b {
        async line(t, e, s, i, h) {
          const a = this._options(h);
          return this._drawable("line", [await this.lib.line(t, e, s, i, a)], a);
        }
        async rectangle(t, e, s, i, h) {
          const a = this._options(h),
            n = [];
          if (a.fill) {
            const h = [t, t + s, t + s, t],
              l = [e, e, e + i, e + i];
            "solid" === a.fillStyle ? n.push(await this.lib.solidFillShape(h, l, a)) : n.push(await this.lib.hachureFillShape(h, l, a));
          }
          return n.push(await this.lib.rectangle(t, e, s, i, a)), this._drawable("rectangle", n, a);
        }
        async ellipse(t, e, s, i, h) {
          const a = this._options(h),
            n = [];
          if (a.fill)
            if ("solid" === a.fillStyle) {
              const h = await this.lib.ellipse(t, e, s, i, a);
              (h.type = "fillPath"), n.push(h);
            } else n.push(await this.lib.hachureFillEllipse(t, e, s, i, a));
          return n.push(await this.lib.ellipse(t, e, s, i, a)), this._drawable("ellipse", n, a);
        }
        async circle(t, e, s, i) {
          let h = await this.ellipse(t, e, s, s, i);
          return (h.shape = "circle"), h;
        }
        async linearPath(t, e) {
          const s = this._options(e);
          return this._drawable("linearPath", [await this.lib.linearPath(t, !1, s)], s);
        }
        async polygon(t, e) {
          const s = this._options(e),
            i = [];
          if (s.fill) {
            let e = [],
              h = [];
            for (let s of t) e.push(s[0]), h.push(s[1]);
            "solid" === s.fillStyle ? i.push(await this.lib.solidFillShape(e, h, s)) : i.push(await this.lib.hachureFillShape(e, h, s));
          }
          return i.push(await this.lib.linearPath(t, !0, s)), this._drawable("polygon", i, s);
        }
        async arc(t, e, s, i, h, a, n, l) {
          const r = this._options(l),
            o = [];
          if (n && r.fill)
            if ("solid" === r.fillStyle) {
              let n = await this.lib.arc(t, e, s, i, h, a, !0, !1, r);
              (n.type = "fillPath"), o.push(n);
            } else o.push(await this.lib.hachureFillArc(t, e, s, i, h, a, r));
          return o.push(await this.lib.arc(t, e, s, i, h, a, n, !0, r)), this._drawable("arc", o, r);
        }
        async curve(t, e) {
          const s = this._options(e);
          return this._drawable("curve", [await this.lib.curve(t, s)], s);
        }
        async path(t, e) {
          const s = this._options(e),
            i = [];
          if (!t) return this._drawable("path", i, s);
          if (s.fill)
            if ("solid" === s.fillStyle) i.push({ type: "path2Dfill", path: t });
            else {
              const e = this._computePathSize(t);
              let h = [0, e[0], e[0], 0],
                a = [0, 0, e[1], e[1]],
                n = await this.lib.hachureFillShape(h, a, s);
              (n.type = "path2Dpattern"), (n.size = e), (n.path = t), i.push(n);
            }
          return i.push(await this.lib.svgPath(t, s)), this._drawable("path", i, s);
        }
      }
      class w {
        constructor(t, e) {
          (this.canvas = t), (this.ctx = this.canvas.getContext("2d")), this._init(e);
        }
        _init(t) {
          this.gen = new b(t, this.canvas);
        }
        get generator() {
          return this.gen;
        }
        static createRenderer() {
          return new x();
        }
        line(t, e, s, i, h) {
          let a = this.gen.line(t, e, s, i, h);
          return this.draw(a), a;
        }
        rectangle(t, e, s, i, h) {
          let a = this.gen.rectangle(t, e, s, i, h);
          return this.draw(a), a;
        }
        ellipse(t, e, s, i, h) {
          let a = this.gen.ellipse(t, e, s, i, h);
          return this.draw(a), a;
        }
        circle(t, e, s, i) {
          let h = this.gen.circle(t, e, s, i);
          return this.draw(h), h;
        }
        linearPath(t, e) {
          let s = this.gen.linearPath(t, e);
          return this.draw(s), s;
        }
        polygon(t, e) {
          let s = this.gen.polygon(t, e);
          return this.draw(s), s;
        }
        arc(t, e, s, i, h, a, n, l) {
          let r = this.gen.arc(t, e, s, i, h, a, n, l);
          return this.draw(r), r;
        }
        curve(t, e) {
          let s = this.gen.curve(t, e);
          return this.draw(s), s;
        }
        path(t, e) {
          let s = this.gen.path(t, e);
          return this.draw(s), s;
        }
        draw(t) {
          let e = t.sets || [],
            s = t.options || this.gen.defaultOptions,
            i = this.ctx;
          for (let t of e)
            switch (t.type) {
              case "path":
                i.save(), (i.strokeStyle = s.stroke), (i.lineWidth = s.strokeWidth), this._drawToContext(i, t), i.restore();
                break;
              case "fillPath":
                i.save(), (i.fillStyle = s.fill), this._drawToContext(i, t, s), i.restore();
                break;
              case "fillSketch":
                this._fillSketch(i, t, s);
                break;
              case "path2Dfill": {
                this.ctx.save(), (this.ctx.fillStyle = s.fill);
                let e = new Path2D(t.path);
                this.ctx.fill(e), this.ctx.restore();
                break;
              }
              case "path2Dpattern": {
                let e = t.size,
                  i = document.createElement("canvas");
                (i.width = e[0]), (i.height = e[1]), this._fillSketch(i.getContext("2d"), t, s), this.ctx.save(), (this.ctx.fillStyle = this.ctx.createPattern(i, "repeat"));
                let h = new Path2D(t.path);
                this.ctx.fill(h), this.ctx.restore();
                break;
              }
            }
        }
        _fillSketch(t, e, s) {
          let i = s.fillWeight;
          0 > i && (i = s.strokeWidth / 2), t.save(), (t.strokeStyle = s.fill), (t.lineWidth = i), this._drawToContext(t, e), t.restore();
        }
        _drawToContext(t, e) {
          t.beginPath();
          for (let s of e.ops) {
            const e = s.data;
            switch (s.op) {
              case "move":
                t.moveTo(e[0], e[1]);
                break;
              case "bcurveTo":
                t.bezierCurveTo(e[0], e[1], e[2], e[3], e[4], e[5]);
                break;
              case "qcurveTo":
                t.quadraticCurveTo(e[0], e[1], e[2], e[3]);
                break;
              case "lineTo":
                t.lineTo(e[0], e[1]);
            }
          }
          "fillPath" === e.type ? t.fill() : t.stroke();
        }
      }
      class O extends w {
        _init(t) {
          this.gen = new m(t, this.canvas);
        }
        async line(t, e, s, i, h) {
          let a = await this.gen.line(t, e, s, i, h);
          return this.draw(a), a;
        }
        async rectangle(t, e, s, i, h) {
          let a = await this.gen.rectangle(t, e, s, i, h);
          return this.draw(a), a;
        }
        async ellipse(t, e, s, i, h) {
          let a = await this.gen.ellipse(t, e, s, i, h);
          return this.draw(a), a;
        }
        async circle(t, e, s, i) {
          let h = await this.gen.circle(t, e, s, i);
          return this.draw(h), h;
        }
        async linearPath(t, e) {
          let s = await this.gen.linearPath(t, e);
          return this.draw(s), s;
        }
        async polygon(t, e) {
          let s = await this.gen.polygon(t, e);
          return this.draw(s), s;
        }
        async arc(t, e, s, i, h, a, n, l) {
          let r = await this.gen.arc(t, e, s, i, h, a, n, l);
          return this.draw(r), r;
        }
        async curve(t, e) {
          let s = await this.gen.curve(t, e);
          return this.draw(s), s;
        }
        async path(t, e) {
          let s = await this.gen.path(t, e);
          return this.draw(s), s;
        }
      }
      var S = { canvas: (t, e) => (e && e.async ? new O(t, e) : new w(t, e)), createRenderer: () => w.createRenderer(), generator: (t, e) => (t && t.async ? new m(t, e) : new b(t, e)) };
      return S;
    })(),
    e = function (t) {
      for (var e = arguments.length, s = Array(e > 1 ? e - 1 : 0), i = 1; i < e; i++) s[i - 1] = arguments[i];
      return Object.assign.apply(Object, [{}, t].concat(s));
    },
    s = function (t) {
      var e = t.h,
        s = t.s,
        i = t.l,
        h = t.a;
      return "hsla(" + e + "," + s + "%," + i + "%," + h + ")";
    },
    i = e.bind(null, { h: 0, s: 100, l: 100, a: 1 }),
    h = e.bind(null, { x: 0, y: 0 }),
    a = e.bind(null, { pos: h(), vel: h(), angle: 0, speed: 0, radius: 0, rotation: 0, color: i() }),
    n = [i({ h: 20, s: 100, l: 50 }), i({ h: 200, l: 50 }), i({ h: 300, l: 50 }), i({ h: 100, l: 40 })],
    l = function e(i) {
      i.animation && i.animation(e.bind(null, i));
      var h = i.ctx,
        a = h.canvas,
        n = t.canvas(a);
      h.clearRect(0, 0, a.width, a.height),
        i.particles.map(function (t, e) {
          (t.pos.y -= t.speed),
            (t.pos.x = e % 2 ? t.pos.x + 0.2 * Math.sin(t.angle) : t.pos.x - 0.2 * Math.cos(t.angle)),
            (t.angle += 0.01),
            n.circle(t.pos.x, t.pos.y, t.radius, { fill: s(t.color), roughness: 1.5 * Math.random(), hachureGap: t.hachureGap, hachureAngle: t.hachureAngle }),
            n.line(t.pos.x, t.pos.y + 1.2 * t.radius, t.pos.x, t.pos.y + t.radius / 2, { bowing: 3 * Math.random() }),
            t.pos.y + 3 * t.radius < 0 && ((t.pos.y = a.height + 3 * t.radius), (t.pos.x = Math.random() * (a.width - t.radius)));
        });
    },
    r = { animation: requestAnimationFrame.bind(null), ctx: document.createElement("canvas").getContext("2d"), title: "Brian Douglas", rotation: 0, particles: [] };
  !(function (t) {
    var e = t.ctx.canvas;
    e.setAttribute("style", "pointer-events:none;position:fixed;z-index:-510;left:0;top:0;right:0;bottom:0;"), (e.width = window.innerWidth), (e.height = window.innerHeight), document.body.appendChild(e);
    for (var s = 50; s--; )
      t.particles.push(
        a({
          pos: { x: Math.random() * e.width, y: Math.random() * e.height },
          speed: Math.random() + 0.2,
          radius: 60 * Math.random() + 20,
          color: n[Math.floor(Math.random() * n.length)],
          hachureAngle: 90 * Math.random(),
          hachureGap: 8 * Math.random() + 1,
        })
      );
    l(t);
  })(r),
    /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ||
      window.addEventListener("resize", function () {
        (r.ctx.canvas.width = window.innerWidth), (r.ctx.canvas.height = window.innerHeight);
      });
})();
