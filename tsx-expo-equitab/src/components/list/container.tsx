import type { PropsWithChildren } from "react"
import { List } from "react-native-ios-list"

type ListContainerProps = PropsWithChildren & {
	title: string
}

export default function ListContainer({ title, children }: ListContainerProps) {
	return (
		<List sideBar inset header={title}>
			{children}
		</List>
	)
}
