import Foundation

protocol HasCodingKeys {
    associatedtype CodingKeys: CodingKey
}

protocol ApiMultipartFormDataRequest: ApiRequest {
    var boundary: String { get }
}

extension Array where Element == Data {
    fileprivate mutating func append(_ newElement: String) {
        append(Data(newElement.utf8))
    }
}

extension ApiMultipartFormDataRequest where Self: HasCodingKeys {
    fileprivate func getCodingKeys() -> CodingKey.Type? {
        return type(of: self).CodingKeys
    }
}

extension ApiMultipartFormDataRequest {
    fileprivate func getCodingKeys() -> CodingKey.Type? {
        return nil
    }

    func toData(method: HttpMethod) throws -> Data {
        var lines: [Data] = []

        let CodingKeys = getCodingKeys()
        for child in Mirror(reflecting: self).children {
            guard
                let label = child.label,
                let key = CodingKeys != nil
                    ? CodingKeys!.init(stringValue: label)?.stringValue : label
            else { continue }

            lines.append("--\(boundary)")
            if child.value is Data {
                lines.append("Content-Disposition: form-data; name=\"\(key)\"; filename=\"\(key)\"")
            } else {
                lines.append("Content-Disposition: form-data; name=\"\(key)\"")
            }
            lines.append("")

            switch child.value {
            case Optional<Any>.none:
                // Remove the field if the value is null
                _ = lines.popLast()
                _ = lines.popLast()
                _ = lines.popLast()

            case let value as Encodable:
                lines.append(try JSONEncoder().encode(value))

            case let value as Int:
                lines.append(String(value))

            case let value as String:
                lines.append(value)

            case let value as Data:
                lines.append(value)

            default:
                throw EncodingError.invalidValue(
                    child.value as Any,
                    EncodingError.Context(
                        codingPath: [],
                        debugDescription: "Unsupported type"
                    )
                )
            }
        }

        // Soft override HTTP Method
        lines.append("--\(boundary)")
        lines.append("Content-Disposition: form-data; name=\"_method\"")
        lines.append("")
        lines.append(method.rawValue)

        lines.append("--\(boundary)--")

        return Data(lines.joined(separator: Data("\r\n".utf8)))
    }
}
